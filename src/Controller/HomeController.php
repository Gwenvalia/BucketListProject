<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;


#[Route(path: "", name: "app_")]
class HomeController extends AbstractController
{

    #[Route(path: "")]
    #[Route(path: "home", name: "home", methods: ["GET"])]
    public function home(): Response
    {
        return $this->render("home/home.html.twig");
    }

    #[Route(path: "about", methods: ["GET"])]
    public function about(KernelInterface $kernel): Response
    {
        $fichierJson = file_get_contents($kernel->getProjectDir() . DIRECTORY_SEPARATOR ."data" . DIRECTORY_SEPARATOR . "team.json");
        $data = json_decode($fichierJson, true);
        //(sans le true, c'est un objet, avec le true, c'est un tableau associatif)

        return $this->render("home/about.html.twig", ["data" => $data]);
    }




}