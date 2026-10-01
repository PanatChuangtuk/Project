<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};
use Carbon\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        // ใบยืม 1 แถวต่อการยืม 1 ครั้ง เก็บสถานะปัจจุบัน
        Schema::create('eqm_history_master', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->index();
            $table->enum('status', ['pending', 'borrowed', 'overdue', 'return_pending', 'returned', 'cancelled'])->index();
            $table->dateTime('borrowed_at');
            $table->dateTime('due_at');
            $table->dateTime('returned_at')->nullable();
            $table->boolean('is_overdue')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // อุปกรณ์แต่ละชิ้นในใบยืม เก็บชิ้นที่ได้รับและสภาพตอนคืน
        Schema::create('eqm_history_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_id')->constrained('eqm_history_master')->cascadeOnDelete();
            $table->integer('equipment_item_id')->index();
            $table->integer('equipment_id')->nullable()->index();
            $table->string('name', 50);
            $table->string('condition', 20)->nullable();
            $table->string('condition_note', 255)->nullable();
            $table->timestamps();
        });

        // เหตุการณ์ทั้งหมด เพิ่มอย่างเดียว ไม่แก้ไข
        Schema::create('eqm_borrow_return_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_id')->constrained('eqm_history_master')->cascadeOnDelete();
            $table->foreignId('detail_id')->nullable()->constrained('eqm_history_detail')->cascadeOnDelete();
            $table->string('action', 30);
            $table->integer('equipment_id')->nullable();
            $table->string('condition', 20)->nullable();
            $table->string('note', 255)->nullable();
            $table->integer('member_id')->nullable();
            $table->integer('admin_id')->nullable(); // member.id ของเจ้าหน้าที่ (แอดมินอยู่ในตาราง member)
            // null = ไม่ทราบเวลา (ข้อมูลที่ย้ายมาจากตารางเดิม)
            $table->dateTime('created_at')->nullable();
            $table->index(['master_id', 'action']);
        });

        $this->migrateOldData();
    }

    public function down(): void
    {
        Schema::dropIfExists('eqm_borrow_return_history');
        Schema::dropIfExists('eqm_history_detail');
        Schema::dropIfExists('eqm_history_master');
    }

    /**
     * ย้ายข้อมูลจาก loan_transactions / loan_equipment (ตารางเดิมไม่ถูกลบ)
     * ใช้ id ใบยืมเดิม เพื่อให้เลขรายการในรายงานไม่เปลี่ยน
     */
    private function migrateOldData(): void
    {
        if (!Schema::hasTable('loan_transactions') || !Schema::hasTable('loan_equipment')) {
            return;
        }

        $hasCondition = Schema::hasColumn('loan_equipment', 'condition');
        $note = 'ย้ายจากข้อมูลเดิม';

        foreach (DB::table('loan_transactions')->orderBy('id')->get() as $loan) {
            $status = match (true) {
                $loan->status === 'cancel' => 'cancelled',
                $loan->status_type === 'returned' => $loan->status === 'completed' ? 'returned' : 'return_pending',
                $loan->status_type === 'overdue' => 'overdue',
                default => $loan->status === 'completed' ? 'borrowed' : 'pending',
            };
            $borrowedAt = Carbon::parse($loan->borrowed_at);

            DB::table('eqm_history_master')->insert([
                'id' => $loan->id,
                'member_id' => $loan->member_id,
                'status' => $status,
                'borrowed_at' => $borrowedAt,
                'due_at' => $borrowedAt->copy()->addDays(7),
                'returned_at' => $loan->returned_at,
                'is_overdue' => (bool) $loan->is_overdue,
                'created_at' => $loan->created_at,
                'updated_at' => $loan->updated_at,
                'deleted_at' => $loan->deleted_at,
            ]);

            $events = [];
            $lines = DB::table('loan_equipment')
                ->where('loan_transactions_id', $loan->id)
                ->whereNull('deleted_at')
                ->orderBy('id')
                ->get();

            foreach ($lines as $line) {
                // ตารางเดิมเคยเก็บ quantity > 1 ในแถวเดียว ตารางใหม่แยก 1 แถวต่อ 1 ชิ้น
                for ($i = 0; $i < max((int) $line->quantity, 1); $i++) {
                    $detailId = DB::table('eqm_history_detail')->insertGetId([
                        'master_id' => $loan->id,
                        'equipment_item_id' => $line->equipment_item_id,
                        'equipment_id' => $line->equipment_id,
                        'name' => $line->name,
                        'condition' => $hasCondition ? $line->condition : null,
                        'condition_note' => $hasCondition ? $line->condition_note : null,
                        'created_at' => $line->created_at,
                        'updated_at' => $line->updated_at,
                    ]);

                    $events[] = ['detail_id' => $detailId, 'action' => 'request', 'member_id' => $loan->member_id, 'created_at' => $loan->created_at ?? $loan->borrowed_at];
                    if ($line->equipment_id && $status !== 'pending') {
                        $events[] = ['detail_id' => $detailId, 'action' => 'approve_borrow', 'equipment_id' => $line->equipment_id, 'note' => $note];
                    }
                    if ($loan->returned_at && in_array($status, ['return_pending', 'returned'], true)) {
                        $events[] = ['detail_id' => $detailId, 'action' => 'return_request', 'member_id' => $loan->member_id, 'created_at' => $loan->returned_at];
                    }
                    if ($status === 'returned') {
                        $events[] = [
                            'detail_id' => $detailId,
                            'action' => 'approve_return',
                            'equipment_id' => $line->equipment_id,
                            'condition' => $hasCondition ? $line->condition : null,
                            'note' => $note,
                        ];
                    }
                }
            }

            if ($loan->is_overdue) {
                $events[] = ['action' => 'overdue', 'created_at' => $borrowedAt->copy()->addDays(7)];
            }
            if ($status === 'cancelled') {
                $events[] = ['action' => 'cancel', 'note' => $note];
            }

            foreach ($events as $event) {
                DB::table('eqm_borrow_return_history')->insert($event + [
                    'master_id' => $loan->id,
                    'detail_id' => null,
                    'equipment_id' => null,
                    'condition' => null,
                    'note' => null,
                    'member_id' => null,
                    'admin_id' => null,
                    'created_at' => null,
                ]);
            }
        }
    }
};
