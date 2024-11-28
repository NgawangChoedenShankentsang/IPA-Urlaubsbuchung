<?php

namespace App\Controller\Admin;

use App\Entity\Holiday;
use App\Entity\HolidayStatus;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class BookCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Holiday::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            DateTimeField::new('startDate'),
            DateTimeField::new('endDate'),
            AssociationField::new('statusId')
            ->hideOnForm()
            ->setTemplatePath('admin/fields/holiday_status.html.twig'), 
            AssociationField::new('typeId'),
            AssociationField::new('employeeId'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('employeeId', 'name')
            ->add('typeId')
            ->add('statusId')
            ->add('startDate')
            ->add('endDate');
    }

    public function createEntity(string $entityFqcn)
    {
        $holiday = new Holiday();

        // Use the injected EntityManager to find the HolidayStatus entity with ID 1
        $status = $this->entityManager->getRepository(HolidayStatus::class)->find(1);

        if (!$status) {
            throw new \Exception('HolidayStatus with ID 1 not found.');
        }

        $holiday->setStatusId($status);

        return $holiday;
    }
}
