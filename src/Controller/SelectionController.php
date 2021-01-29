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
     * @Route("/selection/supprimer/{id}", name="selection_delete")
     */
    public function supprimer(Request $request, SelectionRepository $selectionRepository, EntityManagerInterface $em, $id){

        $selectionSupprimer = $selectionRepository->find($id);
        if( $request->isMethod("POST")){
            $em->remove($selectionSupprimer);
            $em->flush();
            $this->addFlash("success", "La selection n°$id a bien été supprimé");
            return $this->redirectToRoute("selection");
        }
        return $this->render("selection/supprimer.html.twig", ["selection" => $selectionSupprimer]);
    }

 
}
