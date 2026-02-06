<?php

namespace App\DataFixtures;

use App\Entity\APropos;
use App\Entity\Avis;
use App\Entity\ChiffreCle;
use App\Entity\Contact;
use App\Entity\Faq;
use App\Entity\Membre;
use App\Entity\Partenaire;
use App\Entity\Prestation;
use App\Entity\Realisation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUser($manager);
        $this->loadPrestations($manager);
        $this->loadAPropos($manager);
        $this->loadAvis($manager);
        $this->loadRealisations($manager);
        $this->loadChiffresCles($manager);
        $this->loadFaqs($manager);
        $this->loadMembres($manager);
        $this->loadPartenaires($manager);
        $this->loadContacts($manager);

        $manager->flush();
    }

    private function loadUser(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@business.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'admin'));
        $manager->persist($user);
    }

    private function loadPrestations(ObjectManager $manager): void
    {
        $prestationsData = [
            ['nom' => 'Service Professionnel', 'description' => 'Des prestations de qualité réalisées par des experts qualifiés avec un souci du détail exceptionnel.', 'icone' => 'fa-solid fa-wrench', 'position' => 1],
            ['nom' => 'Rapidité et Efficacité', 'description' => 'Nous travaillons rapidement et efficacement pour vous offrir des solutions optimisées et rapides.', 'icone' => 'fa-solid fa-clock', 'position' => 2],
            ['nom' => 'Reconnaissance et Distinction', 'description' => 'Nos services sont reconnus et se distinguent par leur excellence et leur professionnalisme.', 'icone' => 'fa-solid fa-award', 'position' => 3],
        ];

        foreach ($prestationsData as $data) {
            $prestation = new Prestation();
            $prestation->setNom($data['nom']);
            $prestation->setDescription($data['description']);
            $prestation->setIcone($data['icone']);
            $prestation->setPosition($data['position']);
            $prestation->setActif(true);
            $manager->persist($prestation);
        }
    }

    private function loadAPropos(ObjectManager $manager): void
    {
        $apropos = new APropos();
        $apropos->setTitre('Qui sommes-nous ?');
        $apropos->setParagraphe1('Depuis plus de 15 ans, nous mettons notre expertise au service de nos clients pour leur offrir des prestations de qualité supérieure. Notre équipe de professionnels qualifiés s\'engage à fournir des résultats exceptionnels.');
        $apropos->setParagraphe2('Nous croyons en l\'importance de l\'écoute, de la transparence et de l\'excellence. Chaque projet est une opportunité de démontrer notre savoir-faire et notre engagement envers la satisfaction client.');
        $apropos->setParagraphe3('Notre approche personnalisée garantit que chaque solution est parfaitement adaptée à vos besoins spécifiques, avec un souci constant de la qualité et des délais.');
        $manager->persist($apropos);
    }

    private function loadAvis(ObjectManager $manager): void
    {
        $avisData = [
            [
                'nom' => 'Marie Dupont',
                'poste' => 'Directrice Marketing',
                'contenu' => 'Un travail remarquable ! L\'équipe a su comprendre nos besoins et livrer un résultat qui dépasse nos attentes. Je recommande vivement leurs services.',
                'note' => 5,
            ],
            [
                'nom' => 'Thomas Bernard',
                'poste' => 'Chef de projet',
                'contenu' => 'Professionnalisme et réactivité sont les maîtres mots de cette entreprise. Le suivi du projet était impeccable du début à la fin.',
                'note' => 5,
            ],
            [
                'nom' => 'Sophie Laurent',
                'poste' => 'Responsable Communication',
                'contenu' => 'Excellente collaboration sur notre projet de refonte. L\'équipe est à l\'écoute et force de proposition. Résultat au-delà de nos espérances.',
                'note' => 5,
            ],
            [
                'nom' => 'Pierre Martin',
                'poste' => 'Gérant de PME',
                'contenu' => 'Très satisfait de la prestation. Les délais ont été respectés et la qualité est au rendez-vous. Une équipe compétente et agréable.',
                'note' => 4,
            ],
            [
                'nom' => 'Camille Petit',
                'poste' => 'Architecte d\'intérieur',
                'contenu' => 'Je fais appel à leurs services depuis 3 ans maintenant. La qualité est toujours constante et le service client irréprochable.',
                'note' => 5,
            ],
            [
                'nom' => 'Julien Moreau',
                'poste' => 'Entrepreneur',
                'contenu' => 'Rapport qualité-prix imbattable. L\'équipe est très professionnelle et les résultats parlent d\'eux-mêmes. Je ne changerais pour rien au monde.',
                'note' => 4,
            ],
        ];

        foreach ($avisData as $data) {
            $avis = new Avis();
            $avis->setNom($data['nom']);
            $avis->setPoste($data['poste']);
            $avis->setContenu($data['contenu']);
            $avis->setNote($data['note']);
            $avis->setActif(true);
            $manager->persist($avis);
        }
    }

    private function loadRealisations(ObjectManager $manager): void
    {
        $realisationsData = [
            ['titre' => 'Rénovation Villa Moderne', 'image' => 'realisation-1.jpg'],
            ['titre' => 'Aménagement Bureau Design', 'image' => 'realisation-2.jpg'],
            ['titre' => 'Construction Maison Contemporaine', 'image' => 'realisation-3.jpg'],
            ['titre' => 'Réhabilitation Loft Industriel', 'image' => 'realisation-4.jpg'],
            ['titre' => 'Extension Pavillon de Jardin', 'image' => 'realisation-5.jpg'],
            ['titre' => 'Terrasse et Aménagement Extérieur', 'image' => 'realisation-6.jpg'],
        ];

        foreach ($realisationsData as $data) {
            $realisation = new Realisation();
            $realisation->setTitre($data['titre']);
            $realisation->setImage($data['image']);
            $realisation->setActif(true);
            $manager->persist($realisation);
        }
    }

    private function loadChiffresCles(ObjectManager $manager): void
    {
        $chiffresData = [
            ['nombre' => 15, 'label' => 'Années d\'expérience', 'icone' => 'fa-solid fa-calendar-check', 'position' => 1],
            ['nombre' => 500, 'label' => 'Projets réalisés', 'icone' => 'fa-solid fa-briefcase', 'position' => 2],
            ['nombre' => 98, 'label' => 'Clients satisfaits (%)', 'icone' => 'fa-solid fa-face-smile', 'position' => 3],
            ['nombre' => 25, 'label' => 'Experts qualifiés', 'icone' => 'fa-solid fa-users', 'position' => 4],
        ];

        foreach ($chiffresData as $data) {
            $chiffre = new ChiffreCle();
            $chiffre->setNombre($data['nombre']);
            $chiffre->setLabel($data['label']);
            $chiffre->setIcone($data['icone']);
            $chiffre->setPosition($data['position']);
            $chiffre->setActif(true);
            $manager->persist($chiffre);
        }
    }

    private function loadFaqs(ObjectManager $manager): void
    {
        $faqsData = [
            [
                'question' => 'Quels types de services proposez-vous ?',
                'reponse' => 'Nous proposons une large gamme de services professionnels incluant le conseil, la réalisation de projets sur mesure, la maintenance et le suivi. Chaque prestation est adaptée aux besoins spécifiques de nos clients.',
                'position' => 1,
            ],
            [
                'question' => 'Comment obtenir un devis gratuit ?',
                'reponse' => 'Vous pouvez obtenir un devis gratuit en remplissant le formulaire de contact sur notre site, en nous appelant directement ou en nous envoyant un email. Nous vous répondrons sous 24 à 48 heures avec une proposition détaillée.',
                'position' => 2,
            ],
            [
                'question' => 'Quels sont vos délais d\'intervention ?',
                'reponse' => 'Nos délais varient en fonction de la nature et de l\'ampleur du projet. En général, nous intervenons sous 48 heures pour les urgences et planifions les projets plus importants en concertation avec le client pour respecter ses contraintes.',
                'position' => 3,
            ],
            [
                'question' => 'Proposez-vous une garantie sur vos prestations ?',
                'reponse' => 'Oui, toutes nos prestations sont couvertes par une garantie. La durée varie selon le type de service (de 1 à 10 ans). Nous nous engageons à intervenir rapidement en cas de problème pendant la période de garantie.',
                'position' => 4,
            ],
            [
                'question' => 'Intervenez-vous dans toute la France ?',
                'reponse' => 'Nous intervenons principalement en Île-de-France et dans les grandes métropoles. Pour les projets d\'envergure, nous pouvons nous déplacer sur l\'ensemble du territoire national. N\'hésitez pas à nous contacter pour en discuter.',
                'position' => 5,
            ],
            [
                'question' => 'Quels sont vos modes de paiement ?',
                'reponse' => 'Nous acceptons les virements bancaires, les chèques et les cartes bancaires. Pour les projets importants, nous proposons un échéancier de paiement en plusieurs fois. Un acompte de 30% est généralement demandé à la signature du devis.',
                'position' => 6,
            ],
        ];

        foreach ($faqsData as $data) {
            $faq = new Faq();
            $faq->setQuestion($data['question']);
            $faq->setReponse($data['reponse']);
            $faq->setPosition($data['position']);
            $faq->setActif(true);
            $manager->persist($faq);
        }
    }

    private function loadMembres(ObjectManager $manager): void
    {
        $membresData = [
            [
                'nom' => 'Jean-Pierre Duval',
                'poste' => 'Directeur Général',
                'photo' => 'membre-1.jpg',
                'linkedin' => 'https://linkedin.com/in/',
                'position' => 1,
            ],
            [
                'nom' => 'Claire Fontaine',
                'poste' => 'Directrice Commerciale',
                'photo' => 'membre-2.jpg',
                'linkedin' => 'https://linkedin.com/in/',
                'position' => 2,
            ],
            [
                'nom' => 'Marc Lefebvre',
                'poste' => 'Responsable Technique',
                'photo' => 'membre-3.jpg',
                'linkedin' => 'https://linkedin.com/in/',
                'position' => 3,
            ],
            [
                'nom' => 'Isabelle Roux',
                'poste' => 'Chargée de Communication',
                'photo' => 'membre-4.jpg',
                'linkedin' => 'https://linkedin.com/in/',
                'position' => 4,
            ],
        ];

        foreach ($membresData as $data) {
            $membre = new Membre();
            $membre->setNom($data['nom']);
            $membre->setPoste($data['poste']);
            $membre->setPhoto($data['photo']);
            $membre->setLinkedin($data['linkedin']);
            $membre->setPosition($data['position']);
            $membre->setActif(true);
            $manager->persist($membre);
        }
    }

    private function loadPartenaires(ObjectManager $manager): void
    {
        $partenairesData = [
            ['nom' => 'TechCorp', 'logo' => 'techcorp.svg', 'url' => 'https://example.com', 'position' => 1],
            ['nom' => 'InnoGroup', 'logo' => 'innogroup.svg', 'url' => 'https://example.com', 'position' => 2],
            ['nom' => 'BuildPro', 'logo' => 'buildpro.svg', 'url' => 'https://example.com', 'position' => 3],
            ['nom' => 'DesignLab', 'logo' => 'designlab.svg', 'url' => 'https://example.com', 'position' => 4],
            ['nom' => 'EcoSolutions', 'logo' => 'ecosolutions.svg', 'url' => null, 'position' => 5],
            ['nom' => 'SmartServices', 'logo' => 'smartservices.svg', 'url' => null, 'position' => 6],
        ];

        foreach ($partenairesData as $data) {
            $partenaire = new Partenaire();
            $partenaire->setNom($data['nom']);
            $partenaire->setLogo($data['logo']);
            $partenaire->setUrl($data['url']);
            $partenaire->setPosition($data['position']);
            $partenaire->setActif(true);
            $manager->persist($partenaire);
        }
    }

    private function loadContacts(ObjectManager $manager): void
    {
        $contactsData = [
            [
                'nom' => 'Alice Martin',
                'email' => 'alice.martin@email.fr',
                'telephone' => '+33 6 12 34 56 78',
                'message' => 'Bonjour, je souhaiterais obtenir un devis pour la rénovation de mon appartement de 80m². Pouvez-vous me recontacter ? Merci.',
                'lu' => false,
            ],
            [
                'nom' => 'Robert Lemaire',
                'email' => 'r.lemaire@entreprise.fr',
                'telephone' => '+33 1 45 67 89 01',
                'message' => 'Nous recherchons un prestataire pour l\'aménagement de nos nouveaux bureaux (200m²). Serait-il possible de convenir d\'un rendez-vous cette semaine ?',
                'lu' => true,
            ],
            [
                'nom' => 'Nathalie Girard',
                'email' => 'nathalie.g@gmail.com',
                'telephone' => null,
                'message' => 'Je vous contacte suite à la recommandation d\'un ami. J\'aimerais en savoir plus sur vos prestations de conseil. Cordialement.',
                'lu' => false,
            ],
        ];

        foreach ($contactsData as $data) {
            $contact = new Contact();
            $contact->setNom($data['nom']);
            $contact->setEmail($data['email']);
            $contact->setTelephone($data['telephone']);
            $contact->setMessage($data['message']);
            $contact->setLu($data['lu']);
            $manager->persist($contact);
        }
    }
}
