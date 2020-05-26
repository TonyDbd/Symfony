<?php

namespace App\Controller;

use App\Entity\Employer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/listeDefault", name="liste_default")
     */
    public function listDefault()
    {
        $employer = $this->getDoctrine()->getRepository(Employer::class)->findAll();
        dump($employer);
        return $this->render('default/listeDefault.html.twig', 
            [
                'employer' => $employer,
            ]
        );
    }
}
