<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 24/12/2017
 * Time: 17:05
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertController extends Controller
{
    /**
     * @Route("/nos_logements", name="nos_logements")
     */
    public function indexAction()
    {
        $repository=$this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Advert');
        $adverts=$repository->findAll();

        return $this->render('Advert/index.html.twig', array('adverts'=>$adverts));

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/advert/{id}", name="advert")
     */

    public function advertAction($id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Advert');
        $advert = $repository->find($id);
        return $this->render('Advert/advert.html.twig', array('advert' => $advert));
    }
}