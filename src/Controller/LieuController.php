<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lieu;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LieuRepository; 

class LieuController extends AbstractController
{
    /**
     * @Route("/lieu", name="lieu")
     */
    public function index(LieuRepository $lieuRepository): Response
    {
        $liste_lieux = $lieuRepository->findAll();
        return $this->render('lieu/index.html.twig', [
            'lieux' => $liste_lieux,
        ]);
    }

    /**
     * @Route("/lieu/ajouter", name="lieu_ajouter")
     */
    public function ajouter(Request $request, EntityManagerInterface $em){

        if( $request->request->has("adresse")){
            $adresse = $request->request->get("adresse");
        }
        if( $request->request->has("prix")){
            $prix = $request->request->get("prix");
        }
        if( $request->request->has("surface")){
            $surface = $request->request->get("surface");
        }
        if( $request->request->has("capacite")){
            $capacite = $request->request->get("capacite");
        }
        if( $request->request->has("type")){
            $type = $request->request->get("type");
        }

        if( !empty($adresse) && !empty($prix) && !empty($surface) && !empty($capacite) && !empty($type)) { 

            $newLieu = new Lieu;
            $newLieu->setAdresse($adresse);
            $newLieu->setPrix($prix);
            $newLieu->setSurface($surface);
            $newLieu->setCapacite($capacite);
            $newLieu->setType($type);

            $em->persist($newLieu);
            $em->flush();
        }

        return $this->render("lieu/formulaire.html.twig");
    }
}
