<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ProfesorFrontController extends Controller
{

    public function indexAction(Request $request, $password, $email, $rol){
       

        var_dump($email, $password, $rol);

        return $this->render('principal/profesorIndex.html.twig', array(
            'email'=>$email
        ));

    }
}