<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FamiliaController extends AbstractController
{
    /**
     * @Route("/familia", name="familia")
     */
    public function index(Request $request): Response
    {
        return $this->render('familia.html.twig', [
            'mercredi' => (new \DateTime("now") > new \DateTime("2021-03-10 18:00:00")),
            'jeudi' => (new \DateTime("now") > new \DateTime("2021-03-18 18:00:00")),
        ]);
    }
}
 
