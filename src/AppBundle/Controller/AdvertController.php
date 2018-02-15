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
     * @Route("/nos-logements/{page}", name="nos-logements")
     * @param AdvertRepository $advertRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page = 1, AdvertRepository $advertRepository)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $nbPerPage = Advert::ADVERTS_PER_PAGE;

        $listAdverts = $advertRepository->getAdverts($page, $nbPerPage);

        $nbPages = ceil(count($listAdverts) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        return $this->render('Advert/index.html.twig', array('listAdverts' => $listAdverts, 'nbPages' => $nbPages, 'page' => $page));
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