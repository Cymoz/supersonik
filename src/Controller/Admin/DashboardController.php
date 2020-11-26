<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractDashboardController
{

    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Supersonik')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Équipe', 'fa fa-user', Member::class)
        ];
        // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
    }
}
