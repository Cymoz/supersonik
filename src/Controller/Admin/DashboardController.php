<?php

namespace App\Controller\Admin;

use App\Entity\Member;
<<<<<<< HEAD
=======
use App\Entity\User;
>>>>>>> 446e837a159d156f34b837c03fe571a31b856b39
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
=======

class DashboardController extends AbstractDashboardController
{

>>>>>>> 446e837a159d156f34b837c03fe571a31b856b39
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
<<<<<<< HEAD
            ->setTitle('Agence Supersonik')
=======
            ->setTitle('Supersonik')
>>>>>>> 446e837a159d156f34b837c03fe571a31b856b39
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        return [
<<<<<<< HEAD
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'), // equivalent ===> yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
            // MenuItem::section('Users')
            MenuItem::linkToCrud('Members', 'fa fa-user', Member::class)
        ];
        
=======
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Members', 'fa fa-user', Member::class),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class)
        ];
>>>>>>> 446e837a159d156f34b837c03fe571a31b856b39
        // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
    }
}
