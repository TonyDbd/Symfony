<?php

namespace App\Controller;

use App\Entity\Employer;
use App\Form\EmployerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminController extends AbstractController
{

    /**
     * @Route("/liste", name="liste")
     */
    public function index()
    {
        $employer = $this->getDoctrine()->getRepository(Employer::class)->findAll();
        dump($employer);
        return $this->render('admin/liste.html.twig', 
            [
                'employer' => $employer,
            ]
        );
    }


    //Add
     /**
     * @Route("/add", name="add_employer")
     */
    public function addEmployer(Request $request)
    {

        $form = $this->createForm(EmployerType::class, new Employer());

        $form->handleRequest($request); 

        if ($form->isSubmitted() and $form->isValid()) {
            $photo = $form->get('photo')->getData();
            $name = uniqid().'.'.$photo->guessExtension();
            try {
                $photo->move(
                    $this->getParameter('photo_directory'),
                    $name
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $employer = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employer);
            $entityManager->flush();
            
            return $this->redirectToRoute('liste');
        } else {
            return $this->render('admin/add.html.twig', 
                [
                    'form'=> $form->createView()
                ]
            );
        }   
    }

    //Delete
     /**
     * @Route("/deleteemployer/{employer}", name="delete_employer")
     */
    public function deleteEmployer(Employer $employer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($employer);
        $entityManager->flush();

        return $this->redirectToRoute('liste');
    }
}
