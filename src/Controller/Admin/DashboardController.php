<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Media;
use App\Entity\Member;
use App\Entity\Page;
use App\Entity\Project;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
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
            MenuItem::linkToCrud('Équipe', 'fa fa-user', Member::class),
            MenuItem::linkToCrud('Catégories', 'fa fa-user', Category::class),
            MenuItem::linkToCrud('Customers', 'fa fa-user', Customer::class),
            MenuItem::linkToCrud('Médias', 'fa fa-user', Media::class),
            MenuItem::linkToCrud('Projets', 'fa fa-user', Project::class),
        ];
        // yield MenuItem::linkToCrud('The Label', 'icon class', EntityClass::class);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('build/admin.css');
    }
}
