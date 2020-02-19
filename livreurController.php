<?php

namespace EventBundle\Controller;

use EventBundle\Entity\livreur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Livreur controller.
 *
 */
class livreurController extends Controller
{
    /**
     * Lists all livreur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $livreurs = $em->getRepository('EventBundle:livreur')->findAll();

        return $this->render('livreur/index.html.twig', array(
            'livreurs' => $livreurs,
        ));
    }

    /**
     * Creates a new livreur entity.
     *
     */
    public function newAction(Request $request)
    {
        $livreur = new Livreur();
        $form = $this->createForm('EventBundle\Form\livreurType', $livreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($livreur);
            $em->flush();

            return $this->redirectToRoute('livreur_show', array('id' => $livreur->getId()));
        }

        return $this->render('livreur/new.html.twig', array(
            'livreur' => $livreur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a livreur entity.
     *
     */
    public function showAction(livreur $livreur)
    {
        $deleteForm = $this->createDeleteForm($livreur);

        return $this->render('livreur/show.html.twig', array(
            'livreur' => $livreur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing livreur entity.
     *
     */
    public function editAction(Request $request, livreur $livreur)
    {
        $deleteForm = $this->createDeleteForm($livreur);
        $editForm = $this->createForm('EventBundle\Form\livreurType', $livreur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livreur_edit', array('id' => $livreur->getId()));
        }

        return $this->render('livreur/edit.html.twig', array(
            'livreur' => $livreur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a livreur entity.
     *
     */
    public function delete2Action($id)
    {



        $em = $this->getDoctrine()->getManager();

        $employe = $em->getRepository(livreur::class)->find($id);
        $em->remove($employe);
        $em->flush();
        return $this->redirectToRoute("livreur_index");

    }





    public function deleteAction(Request $request, livreur $livreur)
    {
        $form = $this->createDeleteForm($livreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($livreur);
            $em->flush();
        }

        return $this->redirectToRoute('livreur_index');
    }

    /**
     * Creates a form to delete a livreur entity.
     *
     * @param livreur $livreur The livreur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(livreur $livreur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('livreur_delete', array('id' => $livreur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    function RechercheAction(Request $request){
        $livreur=new livreur();
        $form=$this->createFormBuilder($livreur)
            ->add('nomL')
            ->add('Rechercher',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $livreur=$this->getDoctrine()
                ->getRepository(livreur::class)
                ->findBy(array('nomL'=>$livreur->getNomL()));
        }
        return $this->render('@Event/Default/Recherche.html.twig',
            array('f'=>$form->createView(),'c'=>$livreur,));
}

    public function rechercheEvenementAction(Request $request)
    {
        $event=$request->get('evenm');
        //$event="espece";
        // dump($event);
        $events=$this->getDoctrine()->getManager()->createQuery("select e from EventBundle:livreur e where e.nomL like '%".$event."%'")
            ->getResult();

        //die("aa");
        $jsonData=array();
        $idx=0;
        foreach ($events as $liv) {
            $temp=array(
                'id'=>$liv->getId(),
                'nomL'=>$liv->getNomL(),
                'prenomL'=>$liv->getPrenomL(),
                'Cin'=>$liv->getCin(),
                'email'=>$liv->getEmail(),
                'numTel'=>$liv->getNumTel(),
                'adresse'=>$liv->getAdresse(),
                'disponibilite'=>$liv->getDisponibilite(),
                'nblivraison'=>$liv->getNblivraison()




            );
            $jsonData[$idx++]=$temp;

        }
        dump($jsonData);
         die('aa');
        return new JsonResponse($jsonData);

        //return
    }
}
