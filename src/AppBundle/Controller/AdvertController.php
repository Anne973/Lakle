<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 24/12/2017
 * Time: 17:05
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Advert;
use AppBundle\Repository\AdvertRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertController extends Controller
{
    /**
     * @Route("/nos-logements", name="nos-logements")
     * @param AdvertRepository $advertRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(AdvertRepository $advertRepository)
    {
        $adverts=$advertRepository->findAll();

        return $this->render('Advert/index.html.twig', array('adverts'=>$adverts));

    }

    /**
     * @param Advert $advert
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/advert/{id}", name="advert")
     */
    public function advertAction(Advert $advert)
    {
        return $this->render('Advert/advert.html.twig', array('advert' => $advert));
    }
}