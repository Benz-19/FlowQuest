<?php

namespace App\Http\Controllers\Pages;

use App\Core\BaseController;

class PagesController
{
    public function renderTestPage()
    {
        require __DIR__ . '/../../../../test/landing_test.php';
    }
    public function renderTestingPage()
    {
        require __DIR__ . '/../../../../test/test.php';
    }
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

    //Login
    public function renderPasswordResetPage()
    {
        $controller = new BaseController;
        $controller->renderView('Auth/reset_password');
    }


    // validate the user access
    private function isLoggedIn()
    {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /login');
            exit;
        }
    }
    private function isUser($user_type)
    {
        if (!isset($_SESSION['user_details']['user_type']) || $_SESSION['user_details']['user_type'] !== $user_type) {
            header('Location: /login');
            exit;
        }
    }

    /**
     * FREELANCER RELATED PAGES
     */
    //registration
    public function renderFreelancerOnboardingPage()
    {
        $controller = new BaseController;
        $controller->renderView('Freelancer/freelancer_onboarding');
    }
    // dashboard
    public function renderFreelancerDashboardPage()
    {
        $this->isLoggedIn();
        $this->isUser('freelancer');
        $controller = new BaseController;
        $controller->renderView('Freelancer/dashboard');
    }

    /**
     * CLIENT RELATED PAGES
     */
    // registration
    public function renderClientOnboardingPage()
    {
        $controller = new BaseController;
        $controller->renderView('Client/client_onboarding');
    }
    //dashboard
    public function renderClientDashboardPage()
    {
        $this->isLoggedIn();
        $this->isUser('client');
        $controller = new BaseController;
        $controller->renderView('Client/dashboard');
    }

    /**
     * ADMIN RELATED PAGES
     */
    //dashboard
    public function renderAdminDashboardPage()
    {
        $this->isLoggedIn();
        $this->isUser('admin');
        $controller = new BaseController;
        $controller->renderView('Admin/dashboard');
    }
}
