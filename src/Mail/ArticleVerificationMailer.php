<?php

namespace App\Mail;

use App\Entity\Article;
use App\Entity\Identity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ArticleVerificationMailer
{
    private MailerInterface $mailer;
    private EntityManagerInterface $entityManager;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager) {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(): void
    {
        $identity = $this->entityManager->getRepository(Identity::class)->find(1);
        $articlesFR = $this->entityManager->getRepository(Article::class)->getUnverifiedArticles('fr');
        $articlesEN = $this->entityManager->getRepository(Article::class)->getUnverifiedArticles('en');
        $email = (new TemplatedEmail())
            ->from(new Address($identity->getEmail(), $identity->getNameFr()))
            ->to($identity->getEmail())
            ->subject('Articles verification')
            ->htmlTemplate('emails/verification.html.twig')
            ->context([
                'message' => 'Merci de vérifier le contenu des articles importés suivants:',
                'articlesFr' => $articlesFR,
                'articlesEn' => $articlesEN
            ]);

        $this->mailer->send($email);
    }
}