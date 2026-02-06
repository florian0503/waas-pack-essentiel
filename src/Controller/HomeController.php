<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\AvisRepository;
use App\Repository\RealisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        AvisRepository $avisRepository,
        RealisationRepository $realisationRepository,
        EntityManagerInterface $em,
    ): Response {
        $contactSent = false;

        if ($request->isMethod('POST')) {
            $nom = trim((string) $request->request->get('nom'));
            $email = trim((string) $request->request->get('email'));
            $telephone = trim((string) $request->request->get('telephone'));
            $message = trim((string) $request->request->get('message'));

            if ('' !== $nom && '' !== $email && '' !== $message) {
                $contact = new Contact();
                $contact->setNom($nom);
                $contact->setEmail($email);
                $contact->setTelephone('' !== $telephone ? $telephone : null);
                $contact->setMessage($message);

                $em->persist($contact);
                $em->flush();

                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse(['success' => true]);
                }

                $contactSent = true;
            } elseif ($request->isXmlHttpRequest()) {
                return new JsonResponse(['success' => false], 400);
            }
        }

        return $this->render('home/index.html.twig', [
            'avis' => $avisRepository->findActifs(),
            'realisations' => $realisationRepository->findActives(),
            'contactSent' => $contactSent,
        ]);
    }
}
