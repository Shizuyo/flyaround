<?php

namespace WCS\flyReservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WCSflyReservationBundle:Default:index.html.twig');
    }
}
