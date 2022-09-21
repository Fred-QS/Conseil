<?php

namespace App\Mail;

use App\Entity\Identity;
use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class NewsletterMailer
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
    public function sendEmail(string $lang): void
    {
        $newsletters = $this->entityManager->getRepository(Newsletter::class)->findAll();
        $identity = $this->entityManager->getRepository(Identity::class)->find(1);
        foreach ($newsletters as $newsletter) {
            $email = (new TemplatedEmail())
                ->from(new Address($identity->getEmail(), $identity->getNameFr()))
                ->to($newsletter->getEmail())
                ->subject('Newsletter')
                ->htmlTemplate('emails/newsletter.html.twig')
                ->context([
                    'message' => 'TODO',
                    'lang' => $lang
                ]);

            $this->mailer->send($email);
        }
    }
}