<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Service\AutenticacaoService;
use App\Service\JsonResponseService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AutenticacaoController
 * @Route("/autenticacao", name="autenticacao_")
 *
 * @package App\Controller
 */
class AutenticacaoController extends AbstractFOSRestController
{
    /** @var AutenticacaoService */
    private $autenticacaoService;

    /** @var JsonResponseService */
    private $jsonResponseService;

    /**
     * AutenticacaoController constructor.
     *
     * @param AutenticacaoService $autenticacaoService
     * @param JsonResponseService $jsonResponseService
     */
    public function __construct(AutenticacaoService $autenticacaoService, JsonResponseService $jsonResponseService)
    {
        $this->autenticacaoService = $autenticacaoService;
        $this->jsonResponseService = $jsonResponseService;
    }

    /**
     * @Route("/entrar", name="entrar", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function entrarAction(): JsonResponse
    {
        return $this->json('Página Entrar');
    }

    /**
     * @Rest\Get("/ativacao/{hash}", name="ativacao")
     * @Entity("usuario", expr="repository.findOneBy({'hash_ativacao': hash})")
     * @param Usuario $usuario
     *
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function ativacaoAction(Usuario $usuario): Response
    {
        $this->autenticacaoService->validarLoginUsuario($usuario);

        return $this->jsonResponseService->success(
            [
                'msg' => 'Email ativado com sucesso!',
                'usuario' => $usuario->toArray()
            ]
        );
    }

    /**
     * @Rest\Get("/ativacao/reenviar/{usuario}", name="reenviar_ativacao")
     * @ParamConverter("usuario", class="App\Entity\Usuario")
     * @param $usuario
     *
     * @return Response
     */
    public function reenviarAtivacaoAction(Usuario $usuario): Response
    {

        $this->autenticacaoService->reenviarAtivacao($usuario);

        return $this->jsonResponseService->success(
            [
                'msg' => 'Email de validacao reenviado com sucesso!',
                'usuario' => $usuario->toArray()
            ]
        );
    }
}