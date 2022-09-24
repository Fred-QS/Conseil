<?php

namespace App\Mail;

use App\Entity\Identity;
use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ErrorImportArticleEmail
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
        $email = (new TemplatedEmail())
            ->from(new Address($identity->getEmail(), $identity->getNameFr()))
            ->to($identity->getEmail())
            ->subject('Import articles error')
            ->htmlTemplate('emails/error-import-article.html.twig')
            ->context([
                'lang' => 'fr'
            ]);

        $this->mailer->send($email);
    }
}