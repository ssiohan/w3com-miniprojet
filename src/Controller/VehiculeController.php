<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Entity\VehiculeEquipement;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Préfixe les routes de toutes les méthodes de la classe
 * @Route("/vehicule", name="vehicule_")
 */
class VehiculeController extends AbstractController
{
    /**
     * Liste tous les véhicules
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(VehiculeRepository $vehiculeRepository): Response
    {
        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehiculeRepository->findAll(),
        ]);
    }

    /**
     * Ajoute un nouveau véhicule
     * @Route("/new", name="new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicule);
            $entityManager->flush();

            return $this->redirectToRoute('vehicule_index');
        }

        return $this->render('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Visualise un véhicule
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Vehicule $vehicule, $id): Response
    {
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
            'equipements' => $this->getVehiculeEquipements($id),
        ]);
    }

    /**
     * Edite un véhicule
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vehicule $vehicule, $id): Response
    {

        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicule_index');
        }

        return $this->render('vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'equipements' => $this->getVehiculeEquipements($id),
            'form' => $form->createView(),
        ]);
    }

    /**
     * Supprime un véhicule
     * @Route("/{id}/delete", name="delete", methods={"POST"})
     */
    public function delete(Vehicule $vehicule): Response
    {
        $em = $this->getDoctrine()->getManager();
        // On vérifie que le véhicule ne possède pas d'équipements
        $vehiculeEquipements = $this->getVehiculeEquipements($vehicule->getId());
        // Si il y a des equipements, on les supprime du véhicule
        foreach ($vehiculeEquipements as $vehiculeEquipment) {
            $em->remove($vehiculeEquipment);
        }
        // On peut ensuite supprimer le véhicule sans problème
        $em->remove($vehicule);
        $em->flush();

        return $this->redirectToRoute('vehicule_index');
    }

    /**
     * Récupère tous les équipements du véhicule dont l'id est fourni
     */
    public function getVehiculeEquipements($id)
    {
        $em = $this->getDoctrine()->getManager();
        $vehiculeEquipements = $em->getRepository(VehiculeEquipement::class)->findBy(['vehicule' => $id]);

        return $vehiculeEquipements;
    }
}
