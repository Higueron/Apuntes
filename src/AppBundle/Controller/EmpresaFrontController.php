<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmpresaFrontController extends Controller
{

    public function indexAction(Request $request, $password, $email, $rol){
       
        $data = $request->request->all();

        return $this->render('principal/empresaIndex.html.twig', array(
            'email'=>$email
        ));

    }
}