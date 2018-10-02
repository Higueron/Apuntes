<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ProfesorFrontController extends Controller
{

    public function indexAction(){

        return $this->render('principal/profesorIndex.html.twig');

    }
}