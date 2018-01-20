<?php

namespace Tests\AppBundle\Controller;

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
        yield ['/locataires', Response::HTTP_OK];
        yield ['/actus', Response::HTTP_OK];


    }
}
