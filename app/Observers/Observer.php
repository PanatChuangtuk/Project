<?php

namespace App\Observers;

use App\Enum\ActionEnum;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class Observer
{
    public function created($data)
    {
        if ($data->name !== null) {
            $name = $data->name;
        } else {
            $name = basename($data->image);
        }
        if ($name) {
            Logs::create([
                'module' => $data->getTable(),
                'module_id' => $data->id,
                'action' => ActionEnum::Create,
                'title' => $name,
                'description' => 'Created ' . $data->getTable() . ' with ID: ' . $data->id,
                'created_by' => Auth::user()->id,
            ]);
        }
    }

    public function updated($data)
    {
        if ($data->name !== null) {
            $name = $data->name;
        } else {
            $name = basename($data->image);
        }
        if ($name) {
            Logs::create([
                'module' =>  $data->getTable(),
                'module_id' =>  $data->id,
                'action' => ActionEnum::Update,
                'title' =>  $name,
                'description' => 'Updated ' . $data->getTable() . ' with ID: ' .  $data->id,
                'created_by' => Auth::user()->id,
            ]);
        }
    }

    public function deleted($data)
    {
        Logs::create([
            'module' => $data->getTable(),
            'module_id' =>  $data->id,
            'action' => ActionEnum::Delete,
            'title' => basename($data->image),
            'description' => 'Deleted ' . $data->getTable() . ' with ID: ' .  $data->id,
            'created_by' => Auth::user()->id,
        ]);
    }
}
