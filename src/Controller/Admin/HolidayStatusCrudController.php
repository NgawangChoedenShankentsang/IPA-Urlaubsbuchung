<?php

namespace App\Controller\Admin;

use App\Entity\HolidayStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HolidayStatusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HolidayStatus::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }
    
}
