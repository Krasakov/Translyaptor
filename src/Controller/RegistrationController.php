<?php
namespace App\Controller;

use App\Application\UserApp;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistrationController extends AbstractController
{
    /**
     * @Route(path="/", methods={"GET"}, name="start")
     * @return Response
     */
    public function startPage(): Response
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/register", methods={"GET"}, name="get_form")
     * @return Response
     */
    public function getForm(): Response
    {
        return $this->render('register.html.twig');
    }

    /**
     * @Route("/register", methods={"POST"}, name="user_registration")
     * @param Request $request
     * @param UserApp $userApp
     * @return Response
     */
    public function registerAction(Request $request, UserApp $userApp, RouterInterface $router): Response
    {
        $user = new User();
        $user->setUsername($request->request->get('username'));
        $user->setEmail($request->request->get('email'));
        $user->setPlainPassword($request->request->get('password'));
        $userApp->registrationUser($user);

        return new JsonResponse([
            'redirect' => $router->generate('app_login'),
        ]);
    }

    /**
     * @Route("/login", methods={"POST"}, name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils, RouterInterface $router): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();


        return new JsonResponse([
            'redirect' => $router->generate('start')
        ]);
    }

    /**
     * @Route("/logout", methods={"GET", "POST"}, name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @param FormInterface $form
     * @return Response
     */
    protected function renderFormView(FormInterface $form): Response
    {
        return $this->render('register.html.twig', ['form' => $form->createView()]);
    }
}
