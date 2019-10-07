<?php

namespace App\Service;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use App\Service\Email\EmailService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use SendGrid\Mail\TypeException;

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

    /** @var ValidatorService */
    private $validatorService;

    /** @var EmailService */
    private $emailService;

    /**
     * UsuarioService constructor.
     *
     * @param UsuarioRepository $usuarioRepository
     * @param SerializerService $serializerService
     * @param ValidatorService  $validatorService
     * @param EmailService      $emailService
     */
    public function __construct(
        UsuarioRepository $usuarioRepository,
        SerializerService $serializerService,
        ValidatorService $validatorService,
        EmailService $emailService
    ) {
        $this->usuarioRepository = $usuarioRepository;
        $this->serializerService = $serializerService;
        $this->validatorService = $validatorService;
        $this->emailService = $emailService;
    }

    /**
     * @param $data
     *
     * @return mixed
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function cadastrarUsuario($data)
    {
        /** @var Usuario $usuario */
        $usuario = $this->serializerService->normalizer($data, Usuario::class);
        $errors = $this->validatorService->validate($usuario);

        if ($errors) {
            return $errors;
        }
        
        $usuario->setSenha($this->gerarSenhaHash($usuario->getSenha()));
        $usuario->setHashAtivacao(md5($usuario->getLogin()));

        $this->usuarioRepository->save($usuario);
        $this->emailService->emailValidacaoLogin($usuario);

        return $usuario;
    }

    /**
     * @param int $id
     *
     * @return Usuario|null
     */
    public function find(int $id): ?Usuario
    {
        return $this->usuarioRepository->find($id);
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return Usuario|null
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?Usuario
    {
        return $this->usuarioRepository->findOneBy($criteria, $orderBy);
    }

    /**
     * @param Usuario $usuario
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Usuario $usuario): void
    {
        $this->usuarioRepository->update($usuario);
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
