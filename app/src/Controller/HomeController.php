<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route(path: "/", name: "landing", methods: ['GET'])]
    public function landing(): Response
    {
        return $this->render('home/landing.html.twig', []);
    }
}