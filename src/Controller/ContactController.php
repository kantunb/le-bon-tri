<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            // dd($contactFormData);

            $message = (new Email())
                ->from('contact@lbt.com')
                ->to('admin@lbt.com')
                ->subject('Contact')
                ->text($contactFormData['message'])
                ->html($contactFormData['message']);

            $mailer->send($message);

            $this->addFlash('success', 'Message envoyé!');
            return $this->redirectToRoute('app_index');
        }

        return $this->render('contact/index.html.twig', [
            'form_contact' => $form,
            'form_contact' => $form->createView(),
        ]);
    }
}
