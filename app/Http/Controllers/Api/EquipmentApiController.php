<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{EquipmentType, LoanTransaction, LoanEquipment};
use Illuminate\Support\Facades\{Auth, DB, Http};

class EquipmentApiController extends Controller
{
    public function getType(Request $request)
    {
        $query = $request->get('query');
        $types = DB::table('equipment_category')
            ->select('id', 'name')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('id', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%');
            })
            // ->whereNotIn('id', $selectedIds)
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->take(10)
            ->get();

        return response()->json(['results' => $types]);
    }
    public function getItem(Request $request)
    {
        $query = $request->get('query');
        $types = DB::table('equipment_item')
            ->select('id', 'name')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('id', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%');
            })
            // ->whereNotIn('id', $selectedIds)
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->take(10)
            ->get();

        return response()->json(['results' => $types]);
    }
    public function getEquipment(Request $request)
    {
        $query = $request->get('query');
        $item_id = $request->get('item_id');
        $types = DB::table('equipment')
            ->select('id', 'number', 'equipment_number')
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('id', 'like', '%' . $query . '%')
                    ->orWhere('number', 'like', '%' . $query . '%')->orWhere('equipment_number', 'like', '%' . $query . '%');
            })
            // ->whereNotIn('id', $selectedIds)
            ->where('item_id', $item_id)
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->take(10)
            ->get();

        return response()->json(['results' => $types]);
    }
}
