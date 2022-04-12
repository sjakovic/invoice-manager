<?php


namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class GlobalComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('varCurrentRoute', Route::currentRouteName());
    }
}
