<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BreadCrumb extends Component
{
    public $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = $this->generateBreadcrumb();
    }

    public static function generateBreadcrumb()
    {
        $breadcrumbs = [];

        $breadcrumbs[] = ['title' => 'Home', 'url' => route('administrator.dashboard'), 'active' => false];

        $segments = request()->segments();
        
        $url = '';
        foreach ($segments as $index => $segment) {
            if ($segment === 'administrator') {
                continue;
            }

            $url .= '/' . $segment;

            $isLastSegment = ($index === array_key_last($segments));

            $breadcrumbs[] = [
                'title' => ucfirst($segment),
                'url' => url($url),
                'active' => $isLastSegment,
            ];
        }

        return $breadcrumbs;
    }

    public function render()
    {
        return view('components.breadcrumb', ['breadcrumbs' => $this->breadcrumbs]);
    }
}
