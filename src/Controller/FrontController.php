<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Services\ManagerForMail;
use App\Utility\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * @param Request $request
     * @param ManagerForMail $mail
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @Route("/contact-augustin-kavera", name="contact")
     */
    public function contact(Request $request, ManagerForMail $mail)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $mail->sendContact($contact);
            $this->addFlash('success', 'Votre message a été envoyé');
        }
        return $this->render('front/contact.html.twig',[
            'form' => $form->createView()
        ]);
    }

}
