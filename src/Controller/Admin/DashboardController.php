<?php

namespace App\Controller\Admin;

use App\Entity\Block;
use App\Entity\Newsletter;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tableau de bord');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('admin.pages', 'fas fa-pager', 'admin_page');
        yield MenuItem::linkToCrud('admin.subscribers', 'fas fa-envelope', Newsletter::class);
        yield MenuItem::linkToCrud('admin.users', 'fas fa-user', User::class);
    }
}
