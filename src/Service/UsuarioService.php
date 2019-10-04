<?php

namespace App\Service;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class UsuarioService
 *
 * @package App\Service
 */
class UsuarioService
{
    /** @var UsuarioRepository */
    private $usuarioRepository;

    /**
     * UsuarioService constructor.
     *
     * @param UsuarioRepository $usuarioRepository
     */
    public function __construct(
        UsuarioRepository $usuarioRepository
    ) {
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * @param Usuario $usuario
     *
     * @return mixed
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function cadastrarUsuario(Usuario $usuario)
    {
        $this->usuarioRepository->save($usuario);

        return $usuario;
    }
}