<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Vehicule;
use App\Entity\VehiculeEquipement;
use App\Form\VehiculeEquipementType;
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
     * @Route("/new/{vehiculeId}", name="vehicule_equipement_new", methods={"POST"})
     */
    public function new(Request $request, $vehiculeId): Response
    {
        $vehiculeEquipement = new VehiculeEquipement();
        $form = $this->createForm(VehiculeEquipementType::class, $vehiculeEquipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if (($em->getRepository(VehiculeEquipement::class)->findOneBy([
                'vehicule' => $vehiculeId,
                'equipement' => $vehiculeEquipement->getEquipement()->getId()
            ])) !== null) {
                $this->addFlash('alert', 'Ce véhicule possède déjà cet équipement !');
                return $this->render('vehicule_equipement/new.html.twig', [
                    'vehicule' => $vehiculeId,
                    'vehicule_equipement' => $vehiculeEquipement,
                    'form' => $form->createView(),
                ]);
            } else {       
                         
                // On affecte le vehicule actuellement modifié à $vehiculeEquipement
                $vehicule = $em->getRepository(Vehicule::class)->findOneBy([
                    'id' => $vehiculeId
                ]);
                $equipement = $em->getRepository(Equipement::class)->findOneBy([
                    'id' => $vehiculeEquipement->getEquipement()->getId()
                ]);

                $vehiculeEquipement
                    ->setVehicule($vehicule)
                    ->setEquipement($equipement)
                    ->setNomLong($equipement->getNomLong())
                    ->setPoids($equipement->getPoids());

                $em->persist($vehiculeEquipement);
                $em->flush();

                $this->addFlash('success', 'Cet équipement a bien été ajouté !');
            }
        }
        return $this->render('vehicule_equipement/new.html.twig', [
            'vehicule' => $vehiculeId,
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
     * @Route("/{vehicule}/edit/{equipement}", name="vehicule_equipement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VehiculeEquipement $vehiculeEquipement, $equipement, $vehicule): Response
    {
        $form = $this->createForm(VehiculeEquipementType::class, $vehiculeEquipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // On affecte la modification de l'equipement à $vehiculeEquipement
            $equipementToUpdate = $em->getRepository(Equipement::class)->findOneBy([
                'id' => $equipement
            ]);
            $vehiculeEquipement->setEquipement($equipementToUpdate);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Cet équipement a bien été modifié !');
        }

        return $this->render('vehicule_equipement/edit.html.twig', [
            'vehicule' => $vehicule,
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

        return $this->redirectToRoute(
            'vehicule_edit',
            ['id' => $vehicule]
        );
    }
}
