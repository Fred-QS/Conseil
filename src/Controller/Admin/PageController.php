<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/admin/page', name: 'admin_page')]
    public function index(): Response
    {
        return $this->render('admin/page/index.html.twig');
    }
}
