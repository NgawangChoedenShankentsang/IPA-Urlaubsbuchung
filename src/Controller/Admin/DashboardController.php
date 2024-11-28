<?php

namespace App\Controller\Admin;

use App\Entity\Employees;
use App\Entity\Holiday;
use App\Entity\HolidayTypes;
use App\Entity\HolidayStatus;
use App\Repository\HolidayRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\IconSet;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractDashboardController
{
    private HolidayRepository $holidayRepository;

    public function __construct(HolidayRepository $holidayRepository)
    {
        $this->holidayRepository = $holidayRepository;
    }
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        

        // Fetch holidays with status_id = 2 (Approved), and convert them to an array.
        $holidays = $this->holidayRepository->findBy(['statusId' => 2]);
        // Convert the holidays to an array of events
        $events = [];

        // Loop through the holidays and add them to the events array
        foreach ($holidays as $holiday) {
            $employeeName = $holiday->getEmployeeId() ? $holiday->getEmployeeId()->getFirstName() : 'Unknown';
            // Add the holiday to the events array
            $events[] = [
                'id' => $holiday->getId(),
                'title' => $employeeName . ': ' . $holiday->getTitle(),
                'start' => $holiday->getStartDate()->format('Y-m-d H:i:s'),
                'end' => $holiday->getEndDate()->format('Y-m-d H:i:s'),
                'allDay' => false, // Adjust this based on your needs
                'backgroundColor' => '#FFD8D8',
                'borderColor' => '#FFD8D8',
                'textColor' => '#000000',
            ];
        }
        // Convert the events array to JSON
        $data = json_encode($events);
        // Render the dashboard view
        return $this->render('admin/dashboard.html.twig', compact('data'));
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="logo/artd.ch-logo.png" style="width: 100px; height: auto;" alt="Logo">')
            ->disableDarkMode();

    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('css/admin.css');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa-solid fa-desktop');
        // Fetch the count of holidays with statusId = 1
        $newRequestsCount = $this->holidayRepository->count(['statusId' => 1]);

        // Show the badge in the menu if there are new requests
        $requestLabel = $newRequestsCount > 0
            ? 'Request <span class="badge badge-pill badge-danger">' . $newRequestsCount . '</span>'
            : 'Request';

        yield MenuItem::linkToCrud($requestLabel, 'fa-solid fa-bell', Holiday::class)
            ->setAction(Crud::PAGE_INDEX)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', Employees::class)
            ->setAction(Crud::PAGE_INDEX)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Types', 'fa-solid fa-layer-group', HolidayTypes::class)
            ->setAction(Crud::PAGE_INDEX)
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Status', 'fa-solid fa-tag', HolidayStatus::class)
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
