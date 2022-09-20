<?php

namespace App\Mail;

use App\Entity\Identity;
use App\Entity\Message;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactMailer
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(Message $message, Identity $identity): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($identity->getEmail(), $identity->getNameFr()))
            ->to($identity->getEmail())
            ->subject($message->getSubject())
            ->htmlTemplate('emails/message.html.twig')
            ->context([
                'message' => $message,
            ]);

        $this->mailer->send($email);
    }
}