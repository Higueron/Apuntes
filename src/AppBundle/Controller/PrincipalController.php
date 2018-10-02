<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Alumno;
use AppBundle\Entity\Profesor;
use AppBundle\Entity\Empresa;

class PrincipalController extends Controller
{

    public function indexAction()
    {

        $errorB=false;
        $error="Usuario ya registrado";
        return $this->render('principal/index.html.twig', array('error' => $error, 'errorB' => $errorB));
    }

    public function loginAction(Request $request){

        $data = $request->request->all();

        $em = $this->getDoctrine()->getManager();
        
        $alumno_bd = $em->getRepository('AppBundle:Alumno')->findBy(['email' => $data['email_login']]);
        $profesor_bd = $em->getRepository('AppBundle:Profesor')->findBy(['email' => $data['email_login']]);
        $empresa_bd = $em->getRepository('AppBundle:Empresa')->findBy(['email' => $data['email_login']]);
        
        $alumno_email_bd='';$profesor_email_bd='';$empresa_email_bd='';
        $alumno_password_bd='';$profesor_password_bd='';$empresa_password_bd='';
        $alumno_rol_bd='';$profesor_rol_bd='';$empresa_rol_bd='';

        foreach($alumno_bd as $row){
            $alumno_email_bd=$row->getEmail();
            $alumno_password_bd=$row->getPassword();
            $alumno_rol_bd=$row->getRol();
        }

        foreach($profesor_bd as $row){
            $profesor_email_bd=$row->getEmail();
            $profesor_password_bd=$row->getPassword();
            $profesor_rol_bd=$row->getRol();
        }

        foreach($empresa_bd as $row){
            $empresa_email_bd=$row->getEmail();
            $empresa_password_bd=$row->getPassword();
            $empresa_rol_bd=$row->getRol();
        }

        if($data['email_login'] == $alumno_email_bd || $data['email_login'] == $profesor_email_bd ||$data['email_login'] == $empresa_email_bd){
            
            if($alumno_email_bd != ''){
                $email= $alumno_email_bd;
            }elseif($profesor_email_bd != ''){
                $email=$profesor_email_bd;
            }else{
                $email=$empresa_email_bd;
            }

            $opciones = [
                'cost' => 12,
                'salt' =>'AntonioCarrilloVelasco',
            ];

            if($alumno_password_bd != ''){
                $password=$alumno_password_bd;
            }elseif($profesor_password_bd != ''){
                $password = $profesor_password_bd;
            }else{
                $password = $empresa_password_bd;
            }

            if($alumno_rol_bd != ''){
               $rol=$alumno_rol_bd;
            }elseif($profesor_rol_bd != ''){
               $rol=$profesor_rol_bd;
            }else{
               $rol=$empresa_rol_bd;
            }
            $password_codificada = password_hash($data['password_login'], PASSWORD_BCRYPT, $opciones);

            if($email==$data['email_login'] && $password==$password_codificada){

                if($rol=='ROL_ALUMNO'){
                    return $this->forward('AppBundle:AlumnoFront:index', array(
                        'email'=>$email, 'password'=>$password_codificada, 'rol'=>$rol
                    ));
                }elseif($rol=='ROL_PROFESOR'){
                    return $this->forward('AppBundle:ProfesorFront:index', array(
                        'email'=>$email, 'password'=>$password_codificada, 'rol'=>$rol
                    ));
                }else{
                    return $this->forward('AppBundle:EmpresaFront:index', array(
                        'email'=>$email, 'password'=>$password_codificada, 'rol'=>$rol
                    ));
                }

            }else{
                $error="la contraseña y el email no coinciden";
                $errorB=true;
                return $this->render('principal/index.html.twig', array(
                    'error' => $error,
                    'errorB' => $errorB
                ));
            }
        }else{
            $error="Usuario no registrado";
            $errorB=true;
            return $this->render('principal/index.html.twig', array(
                'error' => $error,
                'errorB' => $errorB
            ));

        }

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

            $opciones = [
                'cost' => 12,
                'salt' =>'AntonioCarrilloVelasco',
            ];
            $email=$data['email'];
            $rol=$data['role'];
            $password = password_hash($data['password'], PASSWORD_BCRYPT, $opciones);

            $this->addUserAction($data['email'], $password, $data['role']);

            if($data['role']=='ROL_ALUMNO'){
                return $this->forward('AppBundle:AlumnoFront:index', array(
                    'email'=>$email, 'password'=>$password, 'rol'=>$rol
                ));

                }elseif($data['role']=='ROL_PROFESOR'){
                    return $this->forward('AppBundle:ProfesorFront:index', array(
                        'email'=>$email, 'password'=>$password, 'rol'=>$rol
                    ));

                }else{
                    return $this->forward('AppBundle:EmpresaFront:index', array(
                        'email'=>$email, 'password'=>$password, 'rol'=>$rol
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

    public function addUserAction($email,$password,$rol){

        $em = $this->getDoctrine()->getManager();

        if($rol=='ROL_ALUMNO'){
            $alumno = new Alumno();
            $alumno->setEmail($email);
            $alumno->setPassword($password);
            $alumno->setRol($rol);
            $em->persist($alumno);
            $em->flush();
        }elseif($rol=='ROL_PROFESOR'){
            $profesor = new Profesor();
            $profesor->setEmail($email);
            $profesor->setPassword($password);
            $profesor->setRol($rol);
            $em->persist($profesor);
            $em->flush();
        }else{
            $empresa = new Empresa();
            $empresa->setEmail($email);
            $empresa->setPassword($password);
            $empresa->setRol($rol);
            $em->persist($empresa);
            $em->flush();
        }
    }

}
