<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AlumnoFrontController extends Controller
{
    public function indexAction(){
        return $this->render('principal/alumnoIndex.html.twig');

    }
}