<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PrincipalController extends Controller
{

    public function indexAction(Request $request)
    {

        return $this->render('principal/index.html.twig');
    }
}
