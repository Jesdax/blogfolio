<?php
/**
 * Created by PhpStorm.
 * User: jesda
 * Date: 10/11/18
 * Time: 01:17
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/dashboard", name="admin")
     */
    public function dashbordUserConnected()
    {
        return $this->render('back/index.html.twig');
    }

}