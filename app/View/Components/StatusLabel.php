<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatusLabel extends Component
{
    public $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function render()
    {
        return view('components.status-label');
    }

    public function getLabel()
    {
        return $this->status == 1 ? 'เปิดใช้งาน' : 'ไม่เปิดใช้งาน';
    }
}
