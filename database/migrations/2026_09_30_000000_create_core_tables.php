<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

/**
 * ตารางหลักของระบบ (เดิมสร้างจากไฟล์ SQL ไม่มี migration)
 * โครงสร้างตรงกับฐานข้อมูลที่ใช้งานอยู่ ณ 2026-10-01
 * ข้ามตารางที่มีอยู่แล้ว เพื่อให้รันบนฐานข้อมูลเดิมได้โดยไม่พัง
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->create('member', function (Blueprint $table) {
            $table->integer('id', true);
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('password');
            $table->string('email');
            $table->integer('status');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
        });

        $this->create('adviser', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('titles_name', 50);
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->text('avatar')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->boolean('status')->nullable()->default(true);
        });

        $this->create('student', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('adviser_id');
            $table->bigInteger('student_number');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('mobile_phone', 10);
            $table->string('email', 100);
            $table->integer('status')->default(1);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        $this->create('member_infomation', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('member_id')->index();
            $table->integer('adviser_id');
            $table->integer('student_id');
            $table->text('avatar')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile_phone', 10)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });

        $this->create('guide', function (Blueprint $table) {
            $table->id();
            $table->string('link_video', 500)->comment('URL video');
            $table->string('video_name')->comment('ชื่อวิดีโอ');
            $table->boolean('status')->default(true)->comment('1=active, 0=inactive');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at')->nullable();
        });

        $this->create('equipment_category', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 50);
            $table->integer('status');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        $this->create('equipment_item', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id')->index();
            $table->string('name', 50);
            $table->integer('status');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->text('image')->nullable();
        });

        // อุปกรณ์รายชิ้น
        $this->create('equipment', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('item_id')->index();
            $table->string('number', 12)->nullable();
            $table->string('equipment_number', 50)->nullable()->comment('เลขครุภัณฑ์');
            $table->integer('status');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->text('image')->nullable();
        });

        $this->create('recommend_equipment', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('member_id');
            $table->text('description');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    public function down(): void
    {
        foreach (['recommend_equipment', 'equipment', 'equipment_item', 'equipment_category', 'guide', 'member_infomation', 'student', 'adviser', 'member'] as $table) {
            Schema::dropIfExists($table);
        }
    }

    private function create(string $name, Closure $callback): void
    {
        if (Schema::hasTable($name)) {
            return;
        }
        Schema::create($name, function (Blueprint $table) use ($callback) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $callback($table);
        });
    }
};
