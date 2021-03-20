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
                "196" => "La Famille Moneta te met au défi de te prendre en photo devant 3 de nos Partenaires (adresses présentes sur le site). Afin de valider ton défi, poste cette photo sur notre groupe Mafiatech 2021 - Groupe privé avec le #défiMoneta."

            ,"167" => "La Famille Fiestichita te met au défi de réaliser une recette de cocktail et de la poster sous forme de vidéo sur notre groupe Mafiatech 2021 - Groupe privé avec le #défiFiestichita."

            ,"197" => "La Famille PreventaDDoRS te met au défi de faire boire de l’eau à un polypote entre 2h et 6h du matin. Afin de valider ton défi, poste une preuve vidéo sur notre groupe Mafiatech 2021 - Groupe privé avec le #défiPreventaDDoRS."


            ,"784" => "La Famille Socioleta te met au défi de retrouver les symboles qu’elle a dissimulé un peu partout dans sa communication. Pour réussir ce défi tu devras te laisser guider par les indices que nous t’avons laissés. Chaque fois que tu trouveras un symbole, reviens ici pour rentrer son code correspondant.
            Premier indice : 5pts, 10pts, 20pts, 50pts, [100pts]"

            ,"294" => "Indice : Un caisson c’est lourd ; avec des musiques adaptées bien-sûr."

            ,"734" => "Indice : Le nôtre n’a pas leak. (À ta place je m’amuserais à cliquer partout)"

            ,"134" => "Quatrième indice : Réseau social chinois. (Si tu ne l’as pas tu peux juste aller cliquer sur le lien dans le taplink)"

            ,"524" => "Bravo tu arrives à la fin de ce jeu de piste ! Maintenant rentre les numéros des symboles, dans le meme ordre que tu les as trouvés."

            ,"294734134524" => "Afin de valider ton défi, il faut que tu remplisses ce formulaire : https://docs.google.com/forms/d/e/1FAIpQLScR8xmuJDa6IxOLFmIWDH0K4hw6CHFboq8IjANi0HkZhZ-sQA/viewform?usp=sf_link"
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
