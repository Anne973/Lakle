<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 20/01/2018
 * Time: 10:17
 */

namespace AppBundle\Controller;


use AppBundle\Form\ForgotPasswordType;
use AppBundle\Form\NewPasswordType;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */

    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/forgot_password", name="forgot_password")
     */

    public function forgotPasswordAction(Request $request)
    {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:User');
            if ($user = $repository->findOneBy(array('email' => $data['email']))) {
                $user->setToken(base64_encode(random_bytes(10)));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $message = (new \Swift_Message('Votre demande de réinitialisation de mot de passe'))
                    ->setFrom($this->getParameter('mailer_user'))
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(

                            'Emails/password.html.twig',
                            array('user' => $user)

                        ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);
                return $this->redirectToRoute('password_confirmation');
            } else {
                $this->get('session')->getFlashBag()->add('info', "Email incorrect");
            }
        }
        return $this->render('Security/forgotPassword.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/password_confirmation", name="password_confirmation")
     */
    public function confirmationAction()
    {
        return $this->render('Security/passwordConfirmation.html.twig');
    }

    /**
     * @Route("/register/{key}", name="register")
     */
    public function newPasswordAction(EntityManagerInterface $em, Request $request, UserRepository $userRepository, $key)
    {
        $form = $this->createForm(NewPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $userRepository->getUser($key);

            $encoded = $this->get('security.password_encoder')->encodePassword($user, $data['password']);
            $user->setPassword($encoded);
            $user->setToken('');
            $em->flush();
            return $this->redirectToRoute('reset_confirmation');
        }

        return $this->render('Security/newPassword.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/reset_confirmation", name="reset_confirmation")
     */

    public
    function resetConfirmationAction()
    {
        return $this->render('Security/resetConfirmation.html.twig');
    }

}