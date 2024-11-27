<?php

namespace App\Controller\Admin;

use App\Entity\Employees;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EmployeesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employees::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName'),
            TextField::new('lastName'),
        ];
    }
    
}
