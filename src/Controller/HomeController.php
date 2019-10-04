<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Service\SerializerService;
use JMS\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 *
 * @package App\Controller
 */
class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function indexAction()
    {
        return $this->json('Pagina Home!');
    }
}