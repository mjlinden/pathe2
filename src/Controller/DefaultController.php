<?php

namespace App\Controller;

use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $departments=$entityManager->getRepository(Department::class)->findAll();
        //dd($departments);
        return $this->render('default/index.html.twig', [
            'departments' => $departments,
            'welkom'=>'Goedemorgen!!!'
        ]);
    }

    #[Route('/department/{id}', name: 'app_department')]
    public function index2(EntityManagerInterface $entityManager,$id): Response
    {
        $department=$entityManager->getRepository(Department::class)->find($id);
        //dd($department);
        return $this->render('default/employees.html.twig', [
            'department' => $department,

        ]);
    }

}
