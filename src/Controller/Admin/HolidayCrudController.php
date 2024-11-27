<?php

namespace App\Controller\Admin;

use App\Entity\Holiday;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Validator\Constraints\Date;

class HolidayCrudController extends AbstractCrudController
{
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
            AssociationField::new('statusId'),
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
            // ->add(BexioAccountNameFilter::new('Bexio_ID')->setFormTypeOption('mapped', false));
    }
    
}
