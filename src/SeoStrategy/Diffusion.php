<?php

namespace App\SeoStrategy;

use App\Entity\Article;
use App\Mail\ArticleVerificationMailer;
use App\Mail\ErrorImportArticleEmail;
use App\Mail\NewsletterMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class Diffusion
{
    public function __construct(
        protected MailerInterface $mailer,
        protected EntityManagerInterface $entityManager,
    ) {}

    /**
     * @throws TransportExceptionInterface
     */
    public function sendNewsLetter(string $state): bool
    {
        if ($state === 'ok') {
            $email = new NewsletterMailer($this->mailer, $this->entityManager);
            $email->sendEmail('fr');
            $email->sendEmail('en');
            return true;
        }

        $email = new ErrorImportArticleEmail($this->mailer, $this->entityManager);
        $email->sendEmail($state);
        return false;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendVerifyArticles(string $state): bool
    {
        if ($state === 'ok') {
            $email = new ArticleVerificationMailer($this->mailer, $this->entityManager);
            $email->sendEmail();
            return true;
        }

        $email = new ErrorImportArticleEmail($this->mailer, $this->entityManager);
        $email->sendEmail($state);
        return false;
    }
}