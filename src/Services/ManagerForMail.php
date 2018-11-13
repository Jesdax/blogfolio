<?php
/**
 * Created by PhpStorm.
 * User: jesda
 * Date: 14/11/18
 * Time: 00:12
 */

namespace App\Services;


use App\Utility\Contact;

class ManagerForMail
{

    const MAIL_FROM = 'no-reply@augustinkavera.com';
    const MAIL_CONTACT = 'a.kavera@outlook.fr';

    private $mailer;
    private $template;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $environment)
    {
        $this->mailer = $mailer;
        $this->template = $environment;
    }

    /**
     * @param $to
     * @param $subject
     * @param $body
     * @param string $from
     */
    public function send($to, $subject, $body, $from = self::MAIL_FROM)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setContentType('text/html')
            ->setBody($body);

        $this->mailer->send($message);
    }

    /**
     * @param Contact $contact
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendContact(Contact $contact)
    {
        $from = $contact->getEmail();
        $subject = $contact->getSubject();
        $body = $this->template->render('mail/contact.html.twig', [
            'contact' => $contact
        ]);
        $this->send(self::MAIL_CONTACT, $subject, $body, $from);
    }

}