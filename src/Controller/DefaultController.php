<?php

namespace App\Controller;

use App\Entity\Department;
use App\Entity\Employee;
use App\Entity\Order;
use App\Form\DepartmentType;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/start', name: 'app_default')]
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

    #[Route('/order/{id}', name: 'app_order')]
    public function order(EntityManagerInterface $entityManager, $id,Request $request)
    {
        $order=new Order();
        $form=$this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            //afhandelen data
            $order = $form->getData();
            $employee=$entityManager->getRepository(Employee::class)->find($id);
            $order->setEmployee($employee);
            //dd($department);
            $entityManager->persist($order);
            $entityManager->flush();
            $this->addFlash('success','De order is toegevoegd');
            return $this->redirectToRoute('app_default');
        }
        return $this->render('default/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_new_department')]
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $department=new Department();
        $form=$this->createForm(DepartmentType::class, $department);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $department = $form->getData();
            //dd($department);
            $entityManager->persist($department);
            $entityManager->flush();
            $this->addFlash('success','De afdeling is toegevoegd');
            return $this->redirectToRoute('app_default');
        }

        return $this->render('default/new.html.twig', [
            'form' => $form,
        ]);
    }

}
