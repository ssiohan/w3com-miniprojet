<?php

namespace App\Controller;

use App\Entity\VehiculeEquipement;
use App\Form\VehiculeEquipement1Type;
use App\Repository\VehiculeEquipementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vehicule/equipement")
 */
class VehiculeEquipementController extends AbstractController
{
    /**
     * @Route("/", name="vehicule_equipement_index", methods={"GET"})
     */
    public function index(VehiculeEquipementRepository $vehiculeEquipementRepository): Response
    {
        return $this->render('vehicule_equipement/index.html.twig', [
            'vehicule_equipements' => $vehiculeEquipementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vehicule_equipement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vehiculeEquipement = new VehiculeEquipement();
        $form = $this->createForm(VehiculeEquipement1Type::class, $vehiculeEquipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehiculeEquipement);
            $entityManager->flush();

            return $this->redirectToRoute('vehicule_equipement_index');
        }

        return $this->render('vehicule_equipement/new.html.twig', [
            'vehicule_equipement' => $vehiculeEquipement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{vehicule}", name="vehicule_equipement_show", methods={"GET"})
     */
    public function show(VehiculeEquipement $vehiculeEquipement): Response
    {
        return $this->render('vehicule_equipement/show.html.twig', [
            'vehicule_equipement' => $vehiculeEquipement,
        ]);
    }

    /**
     * @Route("/{vehicule}/edit", name="vehicule_equipement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VehiculeEquipement $vehiculeEquipement): Response
    {
        $form = $this->createForm(VehiculeEquipement1Type::class, $vehiculeEquipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicule_equipement_index');
        }

        return $this->render('vehicule_equipement/edit.html.twig', [
            'vehicule_equipement' => $vehiculeEquipement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{vehicule}/{equipement}/delete", name="vehicule_equipement_delete", methods={"POST"})
     */
    public function delete($vehicule, $equipement): Response
    {
        $em = $this->getDoctrine()->getManager();
        $equipementToDelete = 
        $em->getRepository(VehiculeEquipement::class)->findOneBy([
            'vehicule' => $vehicule,
            'equipement' => $equipement
            ]);
        $em->remove($equipementToDelete);
        $em->flush();

        return $this->redirectToRoute('vehicule_equipement_index');
    }
}
