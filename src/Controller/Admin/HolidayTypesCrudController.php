<?php

namespace App\Controller\Admin;

use App\Entity\HolidayTypes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HolidayTypesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HolidayTypes::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }

}
