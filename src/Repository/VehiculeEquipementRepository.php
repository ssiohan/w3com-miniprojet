<?php

namespace App\Repository;

use App\Entity\VehiculeEquipement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VehiculeEquipement|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehiculeEquipement|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehiculeEquipement[]    findAll()
 * @method VehiculeEquipement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculeEquipementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehiculeEquipement::class);
    }

    // /**
    //  * @return VehiculeEquipement[] Returns an array of VehiculeEquipement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VehiculeEquipement
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
