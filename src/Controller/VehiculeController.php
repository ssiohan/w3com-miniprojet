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

class VehiculeController extends AbstractController
{
    /**
     * @Route("/", name="vehicule_index", methods={"GET"})
     */
    public function index(VehiculeRepository $vehiculeRepository): Response
    {
        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehiculeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vehicule_new", methods={"GET","POST"})
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
     * @Route("/vehicule/{id}", name="vehicule_show", methods={"GET"})
     */
    public function show(Vehicule $vehicule, $id): Response
    {
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
            'equipements' => $this->getVehiculeEquipements($id),
        ]);
    }

    /**
     * @Route("/vehicule/{id}/edit", name="vehicule_edit", methods={"GET","POST"})
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
     * @Route("/vehicule/{id}/delete", name="vehicule_delete", methods={"POST"})
     */
    public function delete(Vehicule $vehicule): Response
    {
        $em = $this->getDoctrine()->getManager();
        // On vérifie que le véhicule ne possède pas d'équipements
        $vehiculeEquipements = $em->getRepository(VehiculeEquipement::class)->findBy(['vehicule' => $vehicule->getId()]);
        // Si il y a des equipements, on supprime chaque équipement du véhicule avant de supprimer le véhicule
        foreach ($vehiculeEquipements as $equipment) {
            $em->remove($equipment);
        }
        // On peut ensuite supprimer le véhicule sans problème
        $em->remove($vehicule);
        $em->flush();

        return $this->redirectToRoute('vehicule_index');
    }

    public function getVehiculeEquipements($id)
    {
        $em = $this->getDoctrine()->getManager();
        $vehiculeEquipements = $em->getRepository(VehiculeEquipement::class)->findBy(['vehicule' => $id]);

        return $vehiculeEquipements;
    }
}
