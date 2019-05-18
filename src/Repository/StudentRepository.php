<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class StudentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
     * @return Pagerfanta
     */
    public function findAllPaginated() :Pagerfanta
    {
        $query = $this->createQueryBuilder('a');
        $adapter = new DoctrineORMAdapter($query, false, false);
        $pagerFanta = new Pagerfanta($adapter);

        return $pagerFanta;
    }

}
