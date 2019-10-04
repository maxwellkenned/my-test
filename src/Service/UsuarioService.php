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

    /** @var SerializerService */
    private $serializerService;

    /** @var JsonResponseService */
    private $jsonResponseService;

    /** @var ValidatorService */
    private $validatorService;

    /**
     * UsuarioService constructor.
     *
     * @param UsuarioRepository   $usuarioRepository
     * @param SerializerService   $serializerService
     * @param JsonResponseService $jsonResponseService
     * @param ValidatorService    $validatorService
     */
    public function __construct(
        UsuarioRepository $usuarioRepository,
        SerializerService $serializerService,
        JsonResponseService $jsonResponseService,
        ValidatorService $validatorService
    ) {
        $this->usuarioRepository = $usuarioRepository;
        $this->serializerService = $serializerService;
        $this->jsonResponseService = $jsonResponseService;
        $this->validatorService = $validatorService;
    }

    /**
     * @param $usuario
     *
     * @return mixed
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function cadastrarUsuario($usuario)
    {
        $usuario = $this->serializerService->normalizer($usuario, Usuario::class);
        $errors = $this->validatorService->validate($usuario);

        if ($errors) {
            return $errors;
        }
        
        $usuario->setSenha($this->gerarSenhaHash($usuario->getSenha()));

        $this->usuarioRepository->save($usuario);

        return $usuario;
    }

    /**
     * @param string $senha
     *
     * @return false|string
     */
    private function gerarSenhaHash(string $senha)
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }
}
