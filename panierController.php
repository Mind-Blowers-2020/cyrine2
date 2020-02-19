<?php

namespace EventBundle\Controller;

use EventBundle\Entity\panier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Panier controller.
 *
 */
class panierController extends Controller
{
    /**
     * Lists all panier entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $paniers = $em->getRepository('EventBundle:panier')->findAll();

        return $this->render('panier/index.html.twig', array(
            'paniers' => $paniers,
        ));
    }

    /**
     * Creates a new panier entity.
     *
     */
    public function newAction(Request $request)
    {
        $panier = new Panier();
        $form = $this->createForm('EventBundle\Form\panierType', $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($panier);
            $em->flush();

            return $this->redirectToRoute('panier_show', array('id' => $panier->getId()));
        }

        return $this->render('panier/new.html.twig', array(
            'panier' => $panier,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a panier entity.
     *
     */
    public function showAction(panier $panier)
    {
        $deleteForm = $this->createDeleteForm($panier);

        return $this->render('panier/show.html.twig', array(
            'panier' => $panier,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing panier entity.
     *
     */
    public function editAction(Request $request, panier $panier)
    {
        $deleteForm = $this->createDeleteForm($panier);
        $editForm = $this->createForm('EventBundle\Form\panierType', $panier);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('panier_edit', array('id' => $panier->getId()));
        }

        return $this->render('panier/edit.html.twig', array(
            'panier' => $panier,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a panier entity.
     *
     */
    public function deleteAction(Request $request, panier $panier)
    {
        $form = $this->createDeleteForm($panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($panier);
            $em->flush();
        }

        return $this->redirectToRoute('panier_index');
    }

    /**
     * Creates a form to delete a panier entity.
     *
     * @param panier $panier The panier entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(panier $panier)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('panier_delete', array('id' => $panier->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
