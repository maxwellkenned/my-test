<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Service\SerializerService;
use App\Service\UsuarioService;
use App\Service\ValidatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
class UsuarioController extends AbstractController
{
    /** @var UsuarioService */
    private $usuarioService;

    /** @var ValidatorService */
    private $validatorService;

    /**
     * UsuarioController constructor.
     *
     * @param UsuarioService   $usuarioService
     * @param ValidatorService $validatorService
     */
    public function __construct(UsuarioService $usuarioService, ValidatorService $validatorService)
    {
        $this->usuarioService = $usuarioService;
        $this->validatorService = $validatorService;
    }

    /**
     * @Route("/perfil", name="perfil", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function perfilAction()
    {
        return $this->json('Página Perfil');
    }

    /**
     * @Route("/criarconta", name="criar_conta", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function criarContaAction(Request $request)
    {
        try {
            $serializerService = new SerializerService();
            $data = json_decode($request->getContent(), true);
            $usuario = $serializerService->normalizer($data['usuario'], Usuario::class);
            $errors = $this->validatorService->validate($usuario);

            if ($errors) {
                return $this->json(['errors' => $errors]);
            }

            $this->usuarioService->cadastrarUsuario($data);

            return $this->json(['msg' => 'Usuário cadastrado com sucesso!', 'usuario' => $usuario]);
        } catch (Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}