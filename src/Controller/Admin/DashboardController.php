<?php

namespace App\Controller\Admin;

use App\Entity\Employees;
use App\Entity\Holiday;
use App\Entity\HolidayTypes;
use App\Entity\HolidayStatus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\IconSet;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('@EasyAdmin/layout.html.twig');
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('IPA');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('css/admin.css');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa-solid fa-desktop');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', Employees::class)
            ->setAction(Crud::PAGE_INDEX)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Types', 'fa-solid fa-layer-group', HolidayTypes::class)
            ->setAction(Crud::PAGE_INDEX)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Status', 'fa-solid fa-tag', HolidayStatus::class)
            ->setAction(Crud::PAGE_INDEX)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Request', 'fa-solid fa-bell', Holiday::class)
            ->setAction(Crud::PAGE_INDEX)
            ->setPermission('ROLE_ADMIN');
        // Restrict 'Book' menu explicitly for ROLE_USER only
        if ($this->isGranted('ROLE_USER') && !$this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Book', 'fa-solid fa-calendar-days', Holiday::class)
                ->setController(BookCrudController::class)
                ->setAction(Crud::PAGE_INDEX);
    }
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
