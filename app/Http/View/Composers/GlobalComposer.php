<?php


namespace App\Http\View\Composers;

use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class GlobalComposer
{
    public function __construct(
        private CompanyRepository $companyRepository,
    )
    {
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('varCurrentRoute', Route::currentRouteName());
        $view->with('varCompany', $this->companyRepository->getCompanyData());
    }
}
