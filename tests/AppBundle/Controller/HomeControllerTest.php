<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Advert;
use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testUrls($url, $statusCode)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertSame($statusCode, $client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        yield ['/', Response::HTTP_OK];
        yield ['/association', Response::HTTP_OK];
        yield ['/nos-logements', Response::HTTP_OK];
        yield ['/contact', Response::HTTP_OK];
        yield ['/confirmation', Response::HTTP_OK];
        yield ['/proprietaires', Response::HTTP_OK];
        yield ['/formulaire', Response::HTTP_OK];
        yield ['/locataires', Response::HTTP_OK];
        yield ['/actus', Response::HTTP_OK];
        yield ['/mentions_legales', Response::HTTP_OK];

        yield ['/login', Response::HTTP_OK];
        yield ['/forgot_password', Response::HTTP_OK];
        yield ['/password_confirmation', Response::HTTP_OK];
        yield ['/register', Response::HTTP_OK];


    }

    public function urlArticleProvider()
    {
        $client = static::createClient();

        $article = $client->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Article::class)
            ->findBy([], null, 1)[0];
        yield ['/article/'.$article, Response::HTTP_OK];
    }

    public function urlAdvertProvider()
    {
        $client = static::createClient();

        $advert = $client->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Advert::class)
            ->findBy([], null, 1)[0];
        yield ['/advert/'.$advert, Response::HTTP_OK];
    }
}
