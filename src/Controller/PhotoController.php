<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PhotoRepository;
use App\Repository\LieuRepository; 
use App\Form\LieuType;
use App\Entity\Photo;
use App\Entity\Lieu;

class PhotoController extends AbstractController
{
    /**
     * @Route("/photo", name="photo")
     */
    public function index(): Response
    {
        return $this->render('photo/index.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }

    /**
     * @Route("/photo/ajouter", name="photo_ajouter")
     */
    public function ajouter(Request $request, EntityManagerInterface $em)
    {
        $lieu = new Lieu;
        $formPhoto = $this->createForm(LieuType::class, $photo);
        $formPhoto->handleRequest($request);
        if($formPhoto->isSubmitted() && $formPhoto->isValid()){
            if( $fichier = $formPhoto->get("lesphotos")->getData() ){

                foreach($fichier as $fichiers){
                
                $destination = $this->getParameter("dossier_image");
                $nomFichier = pathinfo($fichiers->getClientOriginalName(), PATHINFO_FILENAME);
                $nouveauNom = str_replace(" ", "_", $nomFichier);
                $nouveauNom .= "_" . uniqid() . "." . $fichiers->guessExtension();

                $fichiers->move($destination, $nouveauNom);

                $photo = new Photo;
                $photo->setPhotos($nouveauNom);
                $lieu->addPhotoss($photo);
                dd($lieu);
                }
            }
            
            $em->persist($lieu);
            $em->flush();
            $this->addFlash("success", "Nouvel photo enregistré");
            return $this->redirectToRoute("photo");
        }
        return $this->render("photo/ajouter.html.twig", [ "formPhoto" => $formPhoto->createView() ]);
    }
    /**
     * @Route("/photo/supprimer/{id}", name="photo_supprimer")
     */
    public function supprimer(Request $request, LieuRepository $lieuRepository, PhotoRepository $photoRepository, EntityManagerInterface $em, $lieu_id){
        
         
        
        $photoSupprimer = $photoRepository->find($lieu_id);
         
        
        if( $request->isMethod("POST")){
            $em->remove($photoss);
            $em->remove($photoSupprimer);
            $em->flush();
            $this->addFlash("success", "Le lieu n°$id a bien été supprimé");
            return $this->redirectToRoute("lieu");
        }
        return $this->render("lieu/supprimer.html.twig", ["photo" => $photoSupprimer]);
    }
 
}
