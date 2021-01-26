<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Lieu;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LieuRepository; 
use App\Form\LieuType;

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
        $Lieu = new Lieu; 
        $formLieu = $this->createForm(LieuType::class, $Lieu);
        $formLieu->handleRequest($request);
        if( $formLieu->isSubmitted() && $formLieu->isValid() ){
            if( $fichier = $formLieu->get("image")->getData() ){
                $destination = $this->getParameter("dossier_image");
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $nouveauNom = str_replace(" ", "_", $nomFichier);
                $nouveauNom .= "_" . uniqid() . "." . $fichier->guessExtension();
                /* le fichier uploadé est enregistré dans un dossier temporaire. On va le 
                    déplacer vers le dossier images avec le nouveau nom de fichier */
                $fichier->move($destination, $nouveauNom);
                $Lieu->setImage($nouveauNom);
            }
            $em->persist($Lieu);
            $em->flush();
            $this->addFlash("success", "Le nouveau Lieu a bien été ajouté");
            return $this->redirectToRoute("lieu");
        }
        return $this->render("lieu/formulaire.html.twig", ["formLieu" => $formLieu->createView()]);
    }

    /**
     * @Route("/lieu/modifier/{id}", name="lieu_modifier")
     */
    public function modifier(Request $request, EntityManagerInterface $em, LieuRepository $lr, $id){
        $Lieu = $lr->find($id);
        $formLieu = $this->createForm(LieuType::class, $Lieu);
        $formLieu->handleRequest($request);
        if( $formLieu->isSubmitted() && $formLieu->isValid() ){
            if( $fichier = $formLieu->get("image")->getData() ){
                $destination = $this->getParameter("dossier_image");
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $nouveauNom = str_replace(" ", "_", $nomFichier);
                $nouveauNom .= "_" . uniqid() . "." . $fichier->guessExtension();
                $fichier->move($destination, $nouveauNom);
                $Lieu->setImage($nouveauNom);
            }
            $em->persist($Lieu);
            $em->flush();
            $this->addFlash("success", "Le lieu a bien été modifié");
            return $this->redirectToRoute("lieu");
        }
        return $this->render("lieu/formulaire.html.twig", ["formLieu" => $formLieu->createView()]);
    }

    /**
     * @Route("/lieu/supprimer/{id}", name="lieu_supprimer")
     */
    public function supprimer(Request $request, LieuRepository $lieuRepository, EntityManagerInterface $em, $id){

        $lieuSupprimer = $lieuRepository->find($id);
        if( $request->isMethod("POST")){
            $em->remove($lieuSupprimer);
            $em->flush();
            $this->addFlash("border:solid 3px green", "Le lieu n°$id a bien été supprimé");
            return $this->redirectToRoute("lieu");
        }
        return $this->render("lieu/supprimer.html.twig", ["lieu" => $lieuSupprimer]);
    }

    /**
     * @Route("/lieu/fiche/{id}", name="lieu_fiche")
     */
    public function fiche(LieuRepository $lieuRepository, $id){
        $lieu = $lieuRepository->find($id);
        return $this->render("lieu/fiche.html.twig", [ "lieu" => $lieu ]);
    }
}
