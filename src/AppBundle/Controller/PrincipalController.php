<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PrincipalController extends Controller
{

    public function indexAction()
    {
        $errorB=false;
        $error="Usuario ya registrado";
        return $this->render('principal/index.html.twig', array('error' => $error, 'errorB' => $errorB));
    }

    public function registroAction(Request $request){
        
        $data = $request->request->all();

        $em = $this->getDoctrine()->getManager();

        $existeAlumno = $em->getRepository('AppBundle:Alumno')->findOneBy(['email' => $data['email']]);
        $existeProfesor = $em->getRepository('AppBundle:Profesor')->findOneBy(['email' => $data['email']]);
        $existeEmpresa = $em->getRepository('AppBundle:Empresa')->findOneBy(['email' => $data['email']]);

        $existe=false;

        if($existeAlumno != null || $existeProfesor != null || $existeEmpresa != null){
            $existe=true;
        }else{
            $existe=false;
        }

        if($existe==false){

            if($data['role']=='ROL_ALUMNO'){
                return $this->render('principal/alumnoIndex.html.twig', array(
                    'email' => $data['email'],
                    'password' => $data['password'],
                ));
                }elseif($data['role']=='ROL_PROFESOR'){
                    return $this->render('principal/profesorIndex.html.twig', array(
                        'email' => $data['email'],
                        'password' => $data['password'],
                    ));
                }else{
                    return $this->render('principal/empresaIndex.html.twig', array(
                        'email' => $data['email'],
                        'password' => $data['password'],
                    ));
                }
        }else{

            $error="Usuario ya registrado";
            $errorB=true;
            return $this->render('principal/index.html.twig', array(
                'error' => $error,
                'errorB' => $errorB
            ));
        }
    }
}
