<?php


namespace App\Service;

use App\Entity\DataTransferObject\SimpleMessageDTO;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonResponseService
 *
 * @package App\Service
 */
class JsonResponseService
{
    /** @var Serializer */
    private $serializerService;

    /**
     * JsonResponseService constructor.
     *
     * @param SerializerService $serializerService
     */
    public function __construct(SerializerService $serializerService)
    {
        $this->serializerService = $serializerService;
    }

    /**
     * @param null  $objeto
     * @param array $grupos
     *
     * @return Response
     */
    public function success($objeto = null, array $grupos = ['default'])
    {
        $arrayObjeto = [$objeto];
        $vazio = true;
        array_walk_recursive($arrayObjeto, function ($item) use (&$vazio) {
            $vazio = $vazio && !is_bool($item) && !is_numeric($item) && empty($item);
        });

        $codigoResposta = $vazio ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return $this->gerarResponse($codigoResposta, $grupos, $objeto);
    }

    /**
     * @param int  $code
     * @param null $objeto
     * @param      $grupos
     *
     * @return Response
     */
    private function gerarResponse(int $code, array $grupos, $objeto = null): Response
    {
        if (!$objeto) {
            return new Response('', $code);
        }

        return new Response(
            $this->serializerService->toJsonByGroups($objeto, $grupos),
            $code, ['Content-type' => 'application/json', 'Machine' => gethostname()]
        );
    }

    /**
     * @param null  $objeto
     * @param array $grupos
     *
     * @return Response
     */
    public function badRequest($objeto = null, array $grupos = ['default'])
    {
        return $this->gerarResponse(
            Response::HTTP_BAD_REQUEST,
            $grupos,
            $objeto
        );
    }
}
