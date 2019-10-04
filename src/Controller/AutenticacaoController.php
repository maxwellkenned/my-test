<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AutenticacaoController
 * @Route("/autenticacao", name="autenticacao_")
 *
 * @package App\Controller
 */
class AutenticacaoController extends AbstractController
{
    /**
     * @Route("/entrar", name="entrar", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function entrarAction()
    {
        return $this->json('Página Entrar');
    }

    /**
     * @Route("/ativacao", name="ativacao", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function ativacaoAction()
    {
        return $this->json('Página ativacao');
    }
}