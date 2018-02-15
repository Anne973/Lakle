<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactType;
use AppBundle\Form\OwnerType;
use AppBundle\Repository\AdvertRepository;
use AppBundle\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swift_Attachment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(ArticleRepository $articleRepository, AdvertRepository $advertRepository)
    {
        $lastArticles = $articleRepository->getArticlesInHomepage();
        $lastAdverts = $advertRepository->getAdvertsInHomepage();

        return $this->render('Home/index.html.twig', array('lastArticles' => $lastArticles, 'lastAdverts' => $lastAdverts));

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
    public function contactAction(Request $request, \Swift_Mailer $mailer)
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
            $mailer->send($message);
            return $this->redirectToRoute('confirmation');
        }
        return $this->render('Home/contact.html.twig', array('form' => $form->createView()));

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
     * @Route("/formulaire", name="formulaire")
     */
    public function ownersFormAction(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(OwnerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message = (new \Swift_Message('Demande de mise en gestion'))
                ->setFrom($data['email'])
                ->setTo($this->getParameter('mailer_user'))
                ->setBody(
                    $this->renderView(

                        'Emails/owners.html.twig',
                        array('data' => $data)

                    ),
                    'text/html'
                );
            /** @var UploadedFile $attachment */
            foreach ($data['attachments'] as $attachment) {
                $swiftAtt = \Swift_Attachment::fromPath($attachment->getRealPath())
                    ->setFilename($attachment->getClientOriginalName());
                $message->attach($swiftAtt);
            }
            $mailer->send($message);

            return $this->redirectToRoute('confirmation');

        }
        return $this->render('Home/ownersForm.html.twig', array('form' => $form->createView()));

    }
    /**
     * @Route("/download", name="download")
     */
    public function downloadAction()
    {
        $pdfPath = $this->getParameter('dir.downloads').'/formulaire.pdf';

        return $this->file($pdfPath, 'dossier-demande-logement',ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/status", name="status")
     */
    public function statusAction()
    {
        $pdfPath = $this->getParameter('dir.downloads').'/statuts.pdf';

        return $this->file($pdfPath, 'statut-Laklé',ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/locataires", name="locataires")
     */

    public function tenantsAction()
    {
        return $this->render('Home/tenants.html.twig');
    }

    /**
     * @Route("/mentions_legales", name="mentions_legales")
     */

    public function legalNoticeAction()
    {
        return $this->render('Home/legalNotice.html.twig');
    }

    /**
     * @Route("/documents", name="documents")
     */

    public function documentsAction()
    {
        return $this->render('Home/documents.html.twig');
    }

}
