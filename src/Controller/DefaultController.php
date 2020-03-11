<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function list()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    /**
     * @Route("/show/{id}", name="show_one")
     */
    public function show()
    {
        return $this->render('default/show.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
