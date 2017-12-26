<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 25/12/2017
 * Time: 19:43
 */

namespace AppBundle\Controller;


use AppBundle\AppBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ArticleController extends Controller
{
    /**
     * @Route("/actus/{page}", name="actualites")
     */

    public function indexAction($page = 1)
    {


        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $nbPerPage = 2;

        $listArticles = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Article')
            ->getArticles($page, $nbPerPage);

        $nbPages = ceil(count($listArticles) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        return $this->render('Article/index.html.twig', array('listArticles' => $listArticles, 'nbPages' => $nbPages, 'page' => $page));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/article/{id}", name="article")
     */

    public function articleAction($id)
    {

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Article');
        $article = $repository->find($id);
        return $this->render('Article/article.html.twig', array('article' => $article));

    }
}