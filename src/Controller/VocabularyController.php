<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VocabularyController extends AbstractController
{
    /**
     * @Route(path="/", methods={"GET"}, name="index")
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route(path="/create", methods={"GET", "POST"}, name="create_words")
     */
    public function create()
    {
        return $this->render('work_with_text.html.twig');
    }

    /**
     * @Route(path="/lesson", methods={"GET"}, name="lesson")
     */
    public function lesson()
    {
        return $this->render('lessons.html.twig');
    }
}