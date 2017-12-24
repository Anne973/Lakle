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

class HousingController extends Controller
{
    /**
     * @Route("/nos_logements", name="nos_logements")
     */
    public function housingAction()
    {

        return $this->render('Housing/housing_supply.html.twig');

    }
}