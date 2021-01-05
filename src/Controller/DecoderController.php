<?php

namespace App\Controller;

use App\Form\DecoderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DecoderController extends AbstractController
{
    /**
     * @Route("/decodeur", name="decoder")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(DecoderType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $decode = [
                "foo" => "bar",
            ];

            if (array_key_exists($data['Decoder'], $decode)) {
                return $this->render('decoder/index.html.twig', [
                    'code' => $decode[$data['Decoder']],
                ]);
            }
            return $this->render('decoder/index.html.twig', [
                'wrong' => true,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('decoder/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
