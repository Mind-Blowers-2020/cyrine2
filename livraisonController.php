<?php

namespace EventBundle\Controller;

use EventBundle\Entity\livraison;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Livraison controller.
 *
 */
class livraisonController extends Controller
{
    /**
     * Lists all livraison entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $livraisons = $em->getRepository('EventBundle:livraison')->findAll();
        $active = $em->getRepository("EventBundle:livraison")->findAll();
        $livraisons = $this->get('knp_paginator')->paginate($active, $request->query->get('page', 1), 5);
        return $this->render('livraison/index.html.twig', array(
            'livraisons' => $livraisons,
        ));
    }

    /**
     * Creates a new livraison entity.
     *
     */
    public function newAction(Request $request)
    {
        $livraison = new Livraison();
        $form = $this->createForm('EventBundle\Form\livraisonType', $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($livraison);
            $em->flush();

            return $this->redirectToRoute('livraison_show', array('id' => $livraison->getId()));
        }

        return $this->render('livraison/new.html.twig', array(
            'livraison' => $livraison,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a livraison entity.
     *
     */
    public function showAction(livraison $livraison)
    {
        $deleteForm = $this->createDeleteForm($livraison);

        return $this->render('livraison/show.html.twig', array(
            'livraison' => $livraison,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing livraison entity.
     *
     */
    public function editAction(Request $request, livraison $livraison)
    {
        $deleteForm = $this->createDeleteForm($livraison);
        $editForm = $this->createForm('EventBundle\Form\livraisonType', $livraison);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livraison_edit', array('id' => $livraison->getId()));
        }

        return $this->render('livraison/edit.html.twig', array(
            'livraison' => $livraison,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a livraison entity.
     *
     */
    public function deleteAction(Request $request, livraison $livraison)
    {

        $form = $this->createDeleteForm($livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $em = $this->getDoctrine()->getManager();
            $em->remove($livraison);
            $em->flush();
        }

        return $this->redirectToRoute('livraison_index');
    }

    /**
     * Creates a form to delete a livraison entity.
     *
     * @param livraison $livraison The livraison entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(livraison $livraison)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('livraison_delete', array('id' => $livraison->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function delete2Action($id)
    {



        $em = $this->getDoctrine()->getManager();

        $employe = $em->getRepository(livraison::class)->find($id);
        $em->remove($employe);
        $em->flush();
        return $this->redirectToRoute("livraison_index");

    }
}
