<?php

namespace App\Controller;

use App\Entity\Identity;
use App\Entity\Message;
use App\Mail\ConfirmMailer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;
use App\Mail\ContactMailer;

class ContactController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route(
        path: '/{_locale}/contact',
        name: 'contact',
        requirements: [
            '_locale' => 'en|fr',
        ],
    )]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            /**@var Message $data*/
            $message = new Message();
            $message->setName($data->getName());
            $message->setEmail($data->getEmail());
            $message->setSubject($data->getSubject());
            $message->setContent($data->getContent());
            $message->setCreatedAt(new DateTimeImmutable());
            $message->setSeen(0);

            $entityManager->persist($message);
            $entityManager->flush();

            $identity = $entityManager->getRepository(Identity::class)->find(1);
            $contact = new ContactMailer($mailer);
            $contact->sendEmail($message, $identity);

            $confirm = new ConfirmMailer($mailer);
            $confirm->sendEmail($message, $identity);

            $this->addFlash('notice', 'notice.submit.good.contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
