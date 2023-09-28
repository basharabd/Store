<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class FrontLayout extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $title;
     
    public function __construct($title = null)
    {
        $this->title = $title ?? config('app.name');
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $categories = Category::active()->get();

        return view('layouts.front' ,compact('categories') );
    }
}