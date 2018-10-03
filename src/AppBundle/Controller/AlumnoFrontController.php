<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Alumno;

class AlumnoFrontController extends Controller
{
    public function indexAction(Request $request, $password, $email, $rol){
        
        $data = $request->request->all();

        return $this->render('principal/alumnoIndex.html.twig', array(
            'email'=>$email
        ));

    }

    public function vistaFormularioAction(){

        return $this->render('front/formularioAlumno.html.twig', array(
            'email'=>$_SESSION['email']
        ));
    }

    public function updateAction(Request $request){

        $data_form=$request->request->all();

        $em = $this->getDoctrine()->getManager();

        $alumno_bd = $em->getRepository('AppBundle:Alumno')->findBy(['email' => $_SESSION['email']]);

        foreach($alumno_bd as $row){
            $row->setNombre($data_form['nombre']);
            $row->setApellidos($data_form['apellidos']);
            $row->setDni($data_form['dni']);
            $row->setTelefono($data_form['telefono']);
            $row->setRama($data_form['rama']);
            $row->setEstado($data_form['estado']);
            $row->setPreferencias($data_form['preferencias']);
            $em->persist($row);
            $em->flush();
        }
        
        $email=$_SESSION['email'];

        return $this->render('principal/alumnoIndex.html.twig', array(
            'email'=>$email
        ));
    }
}