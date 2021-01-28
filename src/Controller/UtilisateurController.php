<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SelectionRepository;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Selection;
use \DateTime;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur/", name="utilisateur")
     */
    public function index(): Response
    {
        $abonne = $this->getUser();
        $livre = $this->getUser();
        $emprunt = $this->getUser();
        return $this->render('lecteur/index.html.twig', [
            'abonne' => $abonne, 'livre' => $livre,
        ]);
    }

    /**
     * @Route("/utilisateur/reserve/{id}", name="utilisateur_reserve")
     */
    public function reserve(Request $request, LieuRepository $lr, EntityManagerInterface $em, $id)
    {
        $lieu = $lr->find($id);
        
        $abonne = $this->getUser();
        
                                    // cette méthode retourne un objet de la classe Entity/Abonne
        if ( $request->isMethod("POST")){ 
        $date_debut = $request->request->get("date_debut");
        
        $date_fin = $request->request->get("date_fin");
       
        
              
        
        $selection = new Selection;
        $selection->setLieu($lieu);
        
        $selection->setAbonne($abonne);
        $selection->setDateDebut(\DateTime::createFromFormat('Y-m-d', $date_debut));
        $selection->setDateFin(\DateTime::createFromFormat('Y-m-d',$date_fin));
            if(!empty($lieu) && !empty($abonne)){ 
            $em->persist($selection);
            $em->flush();
            $this->addFlash("info", "Votre sélection du lieu " . $lieu->getNomLieu() . " à la date du " . $date_debut . " au " . $date_fin . " a bien été enregistré");
        
            return $this->redirectToRoute("confirmation");
            }
            else{
            $this->addFlash("info", "erreur");
            return $this->redirectToRoute("lieu");
            }
        }
       return $this->render("utilisateur/index.html.twig", [ "lieu" => $lieu , "abonne" => $abonne ]);
    }

    /**
     * @Route("/utilisateur/confirmation", name="confirmation")
     */
    public function confirmation(): Response
    {
        return $this->render('utilisateur/confirmation.html.twig', [
            'controller_name' => 'NosServicesController',
        ]);
    }
}