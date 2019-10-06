<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 *
 * @package App\Controller
 */
class HomeController extends AbstractFOSRestController
{

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function indexAction()
    {
        return $this->json('Pagina Home!');
    }
}