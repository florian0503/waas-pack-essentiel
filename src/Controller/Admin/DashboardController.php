<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Entity\Contact;
use App\Entity\Realisation;
use App\Repository\AvisRepository;
use App\Repository\ContactRepository;
use App\Repository\RealisationRepository;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private ContactRepository $contactRepository,
        private AvisRepository $avisRepository,
        private RealisationRepository $realisationRepository,
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $messagesNonLus = $this->contactRepository->count(['lu' => false]);
        $totalMessages = $this->contactRepository->count([]);
        $totalAvis = $this->avisRepository->count([]);
        $totalRealisations = $this->realisationRepository->count([]);

        return $this->render('admin/dashboard.html.twig', [
            'messagesNonLus' => $messagesNonLus,
            'totalMessages' => $totalMessages,
            'totalAvis' => $totalAvis,
            'totalRealisations' => $totalRealisations,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BusinessPro Admin');
    }

    public function configureMenuItems(): iterable
    {
        $messagesNonLus = $this->contactRepository->count(['lu' => false]);
        $badge = $messagesNonLus > 0 ? ' ('.$messagesNonLus.')' : '';

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Avis clients', 'fa fa-star', Avis::class);
        yield MenuItem::linkToCrud('Réalisations', 'fa fa-image', Realisation::class);
        yield MenuItem::linkToCrud('Messages'.$badge, 'fa fa-envelope', Contact::class);
    }
}
