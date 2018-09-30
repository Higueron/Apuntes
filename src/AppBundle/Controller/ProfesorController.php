<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Profesor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Profesor controller.
 *
 */
class ProfesorController extends Controller
{
    /**
     * Lists all profesor entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $profesors = $em->getRepository('AppBundle:Profesor')->findAll();

        return $this->render('profesor/index.html.twig', array(
            'profesors' => $profesors,
        ));
    }

    /**
     * Creates a new profesor entity.
     *
     */
    public function newAction(Request $request)
    {
        $profesor = new Profesor();
        $form = $this->createForm('AppBundle\Form\ProfesorType', $profesor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profesor);
            $em->flush();

            return $this->redirectToRoute('profesor_show', array('id' => $profesor->getId()));
        }

        return $this->render('profesor/new.html.twig', array(
            'profesor' => $profesor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a profesor entity.
     *
     */
    public function showAction(Profesor $profesor)
    {
        $deleteForm = $this->createDeleteForm($profesor);

        return $this->render('profesor/show.html.twig', array(
            'profesor' => $profesor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing profesor entity.
     *
     */
    public function editAction(Request $request, Profesor $profesor)
    {
        $deleteForm = $this->createDeleteForm($profesor);
        $editForm = $this->createForm('AppBundle\Form\ProfesorType', $profesor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profesor_edit', array('id' => $profesor->getId()));
        }

        return $this->render('profesor/edit.html.twig', array(
            'profesor' => $profesor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a profesor entity.
     *
     */
    public function deleteAction(Request $request, Profesor $profesor)
    {
        $form = $this->createDeleteForm($profesor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profesor);
            $em->flush();
        }

        return $this->redirectToRoute('profesor_index');
    }

    /**
     * Creates a form to delete a profesor entity.
     *
     * @param Profesor $profesor The profesor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Profesor $profesor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profesor_delete', array('id' => $profesor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
