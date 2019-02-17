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



}
