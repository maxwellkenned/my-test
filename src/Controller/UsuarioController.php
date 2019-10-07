<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Service\JsonResponseService;
use App\Service\UsuarioService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use SendGrid\Mail\TypeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UsuarioController
 * @Rest\Route("/usuario", name="usuario_")
 *
 * @package App\Controller
 */
class UsuarioController extends AbstractFOSRestController
{
    /** @var UsuarioService */
    private $usuarioService;

    /** @var JsonResponseService */
    private $jsonResponseService;

    /**
     * UsuarioController constructor.
     *
     * @param UsuarioService      $usuarioService
     * @param JsonResponseService $jsonResponseService
     */
    public function __construct(
        UsuarioService $usuarioService,
        JsonResponseService $jsonResponseService
    ) {
        $this->usuarioService = $usuarioService;
        $this->jsonResponseService = $jsonResponseService;
    }

    /**
     * @Rest\Get("/perfil", name="perfil")
     *
     * @return Response
     */
    public function perfilAction(): Response
    {
        $usuario = $this->usuarioService->find(1);

        return $this->jsonResponseService->success(['usuario' => $usuario->toArray()]);
    }

    /**
     * @Rest\Post("/criarconta", name="criar_conta")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TypeException
     */
    public function criarContaAction(Request $request): Response
    {
        $usuario = $this->usuarioService->cadastrarUsuario($request->getContent());

        if ($usuario instanceof Usuario) {
            return $this->jsonResponseService->success(
                [
                    'msg' => 'Email de validacao enviado com sucesso!',
                    'usuario' => $usuario->toArray()
                ]
            );
        }

        return $this->jsonResponseService->badRequest(['errors' => $usuario]);
    }
}
