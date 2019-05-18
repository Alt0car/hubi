<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashBoardController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function noHome(){
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/admin", name="homepage")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository)
    {

        return $this->render(
            'default/index.html.twig'
        );
    }
}