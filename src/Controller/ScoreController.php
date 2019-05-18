<?php

namespace App\Controller;

use App\Entity\Score;
use App\Form\Type\ScoreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{

    /**
     * @Route("/admin/score/new", name="new_score")
     * @param Request $request
     * @return Response
     * @return Response
     */
    public function newAction(Request $request): Response
    {
        $score = new Score();
        $form = $this->createForm(ScoreType::class, $score);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($score);
            $em->flush();
            $this->addFlash('success', 'La note a été ajoutée avec succès!');
        }

        $form = $form->createView();

        return $this->render('score/new.html.twig', ['score_form' => $form]);
    }

}