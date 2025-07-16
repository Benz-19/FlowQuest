<?php

namespace App\Http\Controllers\Pages;

use App\Core\BaseController;

class PagesController
{
    public function renderLandingPage()
    {
        $controller = new BaseController;
        $controller->renderView('Pages/landing');
    }

    // register
    public function renderRegisterPage()
    {
        $controller = new BaseController;
        $controller->renderView('Auth/register');
    }

    //Login
    public function renderLoginPage()
    {
        $controller = new BaseController;
        $controller->renderView('Auth/login');
    }

    //
    public function renderFreelancerOnboardingPage()
    {
        $controller = new BaseController;
        $controller->renderView('Freelancer/freelancer_onboarding');
    }

    //
    public function renderClientOnboardingPage()
    {
        $controller = new BaseController;
        $controller->renderView('Client/client_onboarding');
    }
}
