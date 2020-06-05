<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Vehicule;
use App\Entity\VehiculeEquipement;
use App\Form\VehiculeEquipementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Préfixe les routes de toutes les méthodes de la classe
 * @Route("/vehicule/equipement", name="vehicule_equipement_")
 */
class VehiculeEquipementController extends AbstractController
{
    /**
     * @Route("/new/{vehiculeId}", name="new", methods={"POST"})
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
     * @Route("/{vehiculeId}", name="show", methods={"GET"})
     */
    public function show(VehiculeEquipement $vehiculeEquipement): Response
    {
        return $this->render('vehicule_equipement/show.html.twig', [
            'vehicule_equipement' => $vehiculeEquipement,
        ]);
    }

    /**
     * @Route("/{vehiculeId}/edit/{equipementId}", name="edit", methods={"GET","POST"})
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
     * @Route("/{vehiculeId}/{equipementId}/delete", name="delete", methods={"POST"})
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
