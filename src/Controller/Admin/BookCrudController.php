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
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

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
            AssociationField::new('employeeId'),
            DateTimeField::new('startDate')->setFormat('yyyy-MM-dd HH:mm:ss')->setLabel('Start Date'),
            DateTimeField::new('endDate')->setFormat('yyyy-MM-dd HH:mm:ss')->setLabel('End Date'),
            AssociationField::new('statusId')
            ->hideOnForm()
            ->setTemplatePath('admin/fields/holiday_status.html.twig'), 
            AssociationField::new('typeId'),
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

        // Set default values for startDate and endDate
        $holiday->setStartDate((new \DateTime())->setTime(0, 0)); // Current date, time set to 00:00
        $holiday->setEndDate((new \DateTime())->setTime(23, 59)); // Current date, time set to 23:59

        // Fetch the default status from the database
        $status = $this->entityManager->getRepository(HolidayStatus::class)->find(1);

        if (!$status) {
            throw new \Exception('HolidayStatus with ID 1 not found.');
        }

        $holiday->setStatusId($status);

        return $holiday;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus')->setLabel(false);
            })

            // in PHP 7.4 and newer you can use arrow functions
            // ->update(Crud::PAGE_INDEX, Action::NEW,
            //     fn (Action $action) => $action->setIcon('fa fa-file-alt')->setLabel(false))
        ;
    }
}
