<?php

namespace App\Controller;

use App\Repository\AvisRepository;
use App\Repository\RealisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AvisRepository $avisRepository, RealisationRepository $realisationRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'avis' => $avisRepository->findActifs(),
            'realisations' => $realisationRepository->findActives(),
        ]);
    }
}
