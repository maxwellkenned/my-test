<?php

namespace App\Service;

use App\Entity\Usuario;
use App\Service\Email\EmailService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AutenticacaoService
{
    /** @var UsuarioService $usuarioService */
    private $usuarioService;
    
    /** @var EmailService $emailService */
    private $emailService;

    /**
     * AutenticacaoService constructor.
     *
     * @param UsuarioService $usuarioService
     * @param EmailService   $emailService
     */
    public function __construct(UsuarioService $usuarioService, EmailService $emailService)
    {
        $this->usuarioService = $usuarioService;
        $this->emailService = $emailService;
    }

    /**
     * @param Usuario $usuario
     *
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function validarLoginUsuario(Usuario $usuario): void
    {
        if (!$usuario) {
            throw new NotFoundHttpException('Usuario não encontrado!');
        }

        $usuario->setIsAutenticado(true);

        $this->usuarioService->update($usuario);
    }

    /**
     * @param Usuario $usuario
     *
     * @return \SendGrid\Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function reenviarAtivacao(Usuario $usuario)
    {
        if (!$usuario) {
            throw new NotFoundHttpException('Usuario não encontrado!');
        }
        
        $newHash = md5($usuario->getId() . $usuario->getHashAtivacao());
        
        $usuario->setHashAtivacao($newHash);

        $this->usuarioService->update($usuario);

        return $this->emailService->emailValidacaoLogin($usuario);
    }
}