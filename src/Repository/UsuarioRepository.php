<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class UsuarioRepository
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @package App\Repository
 */
class UsuarioRepository extends ServiceEntityRepository
{
    /**
     * UsuarioRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    /**
     * @param Usuario $usuario
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Usuario $usuario)
    {
        $this->_em->persist($usuario);
        $this->_em->flush();
    }

    /**
     * @param Usuario $usuario
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Usuario $usuario): void
    {
        $this->_em->flush($usuario);
    }
}
