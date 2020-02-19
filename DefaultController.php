<?php

namespace EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Event/Default/index.html.twig');
    }
    public function clientAction()
    {
        return $this->render('@Event/Default/client.html.twig');
    }
    public function blogAction()
    {
        return $this->render('@Event/Default/blog.html.twig');
    }
    public function produitsAction()
    {
        return $this->render('@Event/Default/produits.html.twig');
    }
    public function commandesAction()
    {
        return $this->render('@Event/Default/commandes.html.twig');
    }
    public function livraisonsAction()
    {
        return $this->render('@Event/Default/indexlivraison.html.twig');
    }

    public function livreursAction()
    {
        return $this->render('@Event/Default/livreurs.html.twig');
    }
    public function evenementAction()
    {
        return $this->render('@Event/Default/evenement.html.twig');
    }
    public function guidesAction()
    {
        return $this->render('@Event/Default/guides.html.twig');
    }
    public function participantsAction()
    {
        return $this->render('@Event/Default/participants.html.twig');
    }
}
