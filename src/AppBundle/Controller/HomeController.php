<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Article');
        $lastArticles =
            $repository->findBy(
                array(), // Critere
                array('date' => 'desc'),        // Tri
                3,                              // Limite
                0                            // Offset
            );

        return $this->render('Home/index.html.twig', array('lastArticles'=>$lastArticles));

    }

    /**
     * @Route("/association", name="association")
     */
    public function associationAction()
    {

        return $this->render('Home/association.html.twig');

    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {

        return $this->render('Home/contact.html.twig');

    }
}
