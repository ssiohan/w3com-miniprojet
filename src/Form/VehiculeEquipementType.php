<?php

namespace App\Form;

use App\Entity\VehiculeEquipement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeEquipementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipement')
            ->add('nomLong')
            ->add('poids');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VehiculeEquipement::class,
        ]);
    }
}
