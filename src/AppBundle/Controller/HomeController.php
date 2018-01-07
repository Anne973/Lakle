<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactType;
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

        return $this->render('Home/index.html.twig', array('lastArticles' => $lastArticles));

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
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message = (new \Swift_Message('Contact'))
                ->setFrom($data['email'])
                ->setTo($this->getParameter('mailer_user'))
                ->setBody(
                    $this->renderView(

                        'Emails/contact.html.twig',
                        array('data' => $data)

                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            return $this->redirectToRoute('confirmation');
        }
        return $this->render('Home/contact.html.twig', array('form'=>$form->createView()));

    }

    /**
     * @Route("/confirmation", name="confirmation")
     */
    public function confirmationAction()
    {
        return $this->render('Home/confirmation.html.twig');
    }



    /**
     * @Route("/proprietaires", name="proprietaires")
     */
    public function ownersAction()
    {
        return $this->render('Home/owners.html.twig');
    }

    /**
     * @Route("/locataires", name="locataires")
     */

    public function tenantsAction()
    {
        return $this->render('Home/tenants.html.twig');
    }
}
