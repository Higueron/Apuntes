<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PrincipalController extends Controller
{

    public function indexAction()
    {
        return $this->render('principal/index.html.twig');
    }

    public function registroAction(Request $request){

    }
}
