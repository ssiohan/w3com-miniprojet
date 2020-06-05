<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\VehiculeEquipement;
use App\Form\EquipementType;
use App\Repository\EquipementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipement")
 */
class EquipementController extends AbstractController
{
    /**
     * Liste tous les équipements
     * @Route("/", name="equipement_index", methods={"GET"})
     */
    public function index(EquipementRepository $equipementRepository): Response
    {
        return $this->render('equipement/index.html.twig', [
            'equipements' => $equipementRepository->findAll(),
        ]);
    }

    /**
     * Ajoute un équipement
     * @Route("/new", name="equipement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipement);
            $entityManager->flush();

            return $this->redirectToRoute('equipement_index');
        }

        return $this->render('equipement/new.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Visualise un équipement
     * @Route("/{id}", name="equipement_show", methods={"GET"})
     */
    public function show(Equipement $equipement): Response
    {
        return $this->render('equipement/show.html.twig', [
            'equipement' => $equipement,
        ]);
    }

    /**
     * Edite un équipement
     * @Route("/{id}/edit", name="equipement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipement $equipement): Response
    {
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipement_index');
        }

        return $this->render('equipement/edit.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Supprime un équipement
     * @Route("/{id}/delete", name="equipement_delete", methods={"POST"})
     */
    public function delete(Equipement $equipement): Response
    {
        $em = $this->getDoctrine()->getManager();
        // On vérifie que l'équipement n'est installé sur aucun véhicule
        $equipementVehicules = $this->getEquipementVehicules($equipement->getId());
        // S'il est installé sur des véhicules, on l'enlève des véhicules
        foreach ($equipementVehicules as $equipementVehicule) {
            $em->remove($equipementVehicule);
        }
        // On peut ensuite supprimer l'équipement vu qu'il n'est plus installé sur aucun véhicule
        $em->remove($equipement);
        $em->flush();

        return $this->redirectToRoute('equipement_index');
    }

    /**
     * Récupère tous les véhicules possédant l'équipement dont l'id est fourni
     */
    public function getEquipementVehicules($id)
    {
        $em = $this->getDoctrine()->getManager();
        $equipementVehicules = $em->getRepository(VehiculeEquipement::class)->findBy(['equipement' => $id]);

        return $equipementVehicules;
    }
}
