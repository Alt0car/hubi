<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\Type\StudentType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * StudentController constructor.
     * @param EntityManagerInterface $em
     * @param StudentRepository $studentRepository
     */
    public function __construct(EntityManagerInterface $em, StudentRepository $studentRepository)
    {
        $this->em = $em;
        $this->studentRepository = $studentRepository;
    }

    /**
     * @Route("/admin/students/{page?}", name="students",
     *     defaults={
     *     "limit": "10",
     *     "page": "1"
     *      },
     *     requirements={
     *         "page": "\d+",
     *         "limit": "\d+"
     *     })
     * @param $page
     * @param $limit
     * @return Response
     */
    public function cgetAction($page, $limit): Response
    {

        $studentFanta = $this->studentRepository->findAllPaginated();
        $return["recordsTotal"] = $return["recordsFiltered"] = $studentFanta->getNbResults();

        /** @var Student[] $students */
        $students = $studentFanta->setCurrentPage($page)->setMaxPerPage($limit);

        return $this->render('student/index.html.twig', ['students' => $students]);

    }

    /**
     * @Route("/admin/student/edit/{studentId}", name="edit_student",
     *     requirements={
     *         "studentId": "\d+"
     *     })
     * @param Request $request
     * @param int $studentId
     * @return Response
     */
    public function editAction(Request $request, int $studentId): Response
    {
        /** @var Student $student */
        $student = $this->studentRepository->find($studentId);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'L\'utilisateur a été édité avec succès!');
        }

        $form = $form->createView();

        return $this->render('student/edit.html.twig', ['student_form' => $form]);
    }

    /**
     * @Route("/admin/student/new", name="new_student")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($student);
            $this->em->flush();
            $this->addFlash('success', 'L\'utilisateur a été créé avec succès!');

            return $this->redirect($this->generateUrl('edit_student', ['studentId' => $student->getId()]));
        }

        $form = $form->createView();

        return $this->render('student/new.html.twig', ['student_form' => $form]);
    }

    /**
     * @Route("/admin/student/delete/{studentId}", name="delete_student",
     *     requirements={
     *         "studentId": "\d+"
     *     })
     * @param int $studentId
     * @return JsonResponse
     */
    public function deleteAction(int $studentId): Response
    {

        $student = $this->studentRepository->find($studentId);
        $this->em->remove($student);
        $this->em->flush();
        $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès!');

        return $this->redirect($this->generateUrl('students'));

    }
}