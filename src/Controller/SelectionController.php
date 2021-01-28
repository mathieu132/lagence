<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SelectionRepository;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Selection;
use App\Form\SelectionType;

/**
 * @Route("/admin")
 */
class SelectionController extends AbstractController
{
    /**
     * @Route("/selection", name="selection")
     */
    public function index(SelectionRepository $selectionRepository): Response
    {
        $listeSelections = $selectionRepository->findAll();
        return $this->render('selection/index.html.twig', [
            'selections' => $listeSelections,
        ]);
    }

    /**
     * @Route("/selection/ajouter", name="selection_ajouter")
     */
    public function ajouter(Request $request, EntityManagerInterface $em)
    {
        $selection = new Selection;
        $formSelection = $this->createForm(SelectionType::class, $selection);
        $formSelection->handleRequest($request);
        if($formSelection->isSubmitted() && $formSelection->isValid()){
            $em->persist($selection);
            $em->flush();
            $this->addFlash("success", "Nouvel selection enregistré");
            return $this->redirectToRoute("selection");
        }
        return $this->render("selection/ajouter.html.twig", [ "formSelection" => $formSelection->createView() ]);
    }

    /**
     * @Route("/selection/retour/{id}", name="selection_retour" )
     */
    public function retour(SelectionRepository $er, EntityManagerInterface $em, $id)
    {
        $selectionAmodifier = $er->find($id);
        $selectionAmodifier->setDateRetour(new \DateTime());
        $em->flush();
        $this->addFlash("info", "Le livre <strong>" . $selectionAmodifier->getLivre()->getTitre() . "</strong> selectioné par <i>" . $selectionAmodifier->getAbonne()->getPseudo() . "</i> a été rendu");
        return $this->redirectToRoute("selection");
    }

    /**
     * @Route("/selection/reserver/{id}", name="selection_reserver" )
     */
    public function reserver(LieuRepository $lr, EntityManagerinterface $em, $id){
        
        $lieu = $lr->find($id);
        $abonne = $this->getUser();
        
        $selection = new Selection;
        $selection->setLieu($lieu);
        $selection->setAbonne($abonne);
        $em->persist($selection);
        $em->flush();
        $this->addFlash("info", "Votre sélection " . $lieu->getNomLieu() . " a bien été pris on compte");
        return $this->redirectToRoute("selection");
    }
}
