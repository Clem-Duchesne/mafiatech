<?php

namespace App\Controller;

use App\Form\DecodeurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DecodeurController extends AbstractController
{
    /**
     * @Route("/decodeur", name="decodeur")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(DecodeurType::class);
        $form->handleRequest($request);

        $vendredi = (new \DateTime("now") > new \DateTime("2021-03-19 10:00:00"));
        if ($vendredi === False) {
            return $this->render('decodeur.html.twig', [
                'vendredi' => $vendredi,
                'form' => $form->createView(),
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $decode = [
                "foo" => "bar",
            ];

            if (array_key_exists($data['Decodeur'], $decode)) {
                return $this->render('decodeur.html.twig', [
                    'code' => $decode[$data['Decodeur']],
                    'form' => $form->createView(),
                ]);
            }
            return $this->render('decodeur.html.twig', [
                'wrong' => true,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('decodeur.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
