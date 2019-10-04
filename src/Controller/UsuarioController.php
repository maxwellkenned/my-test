<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Service\JsonResponseService;
use App\Service\SerializerService;
use App\Service\UsuarioService;
use App\Service\ValidatorService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use JMS\Serializer\Exception\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * Class UsuarioController
 * @Route("/usuario", name="usuario_")
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
    public function __construct(UsuarioService $usuarioService, JsonResponseService $jsonResponseService)
    {
        $this->usuarioService = $usuarioService;
        $this->jsonResponseService = $jsonResponseService;
    }

    /**
     * @Get("/perfil", name="perfil")
     *
     * @return JsonResponse
     */
    public function perfilAction()
    {
        return $this->json('Página Perfil');
    }

    /**
     * @Post("/criarconta", name="criar_conta")
     *
     * @param Request $request
     *
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function criarContaAction(Request $request): Response
    {
        $usuario = $this->usuarioService->cadastrarUsuario($request->getContent());

        if ($usuario instanceof Usuario) {
            return $this->jsonResponseService->success(['usuario' => $usuario->toArray()]);
        }

        return $this->jsonResponseService->badRequest(['errors' => $usuario]);
    }
}
