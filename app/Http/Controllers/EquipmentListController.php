<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\{Auth, DB, Validator, Hash};
use Illuminate\Http\Request;
use App\Models\{EquipmentCategory};

class EquipmentListController extends MainController
{
    public function equipmentListIndex(Request $request)
    {
        // dd($request->all());
        $typeVaule = $request->query('type');
        $equipment = EquipmentCategory::find($typeVaule);
        dd($equipment->item);
        return view('equipment', compact('equipment'));
    }
}
