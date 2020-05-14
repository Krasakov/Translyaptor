<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VocabularyController extends AbstractController
{
    /**
     * @Route(path="/", methods={"GET"}, name="index")
     */
    public function index()
    {
        return $this->render('work_with_text.html.twig');
    }

    /**
     * @Route(path="/handle", methods={"POST"}, name="handle_text")
     *
     * @param Request $request
     * @return Response
     */
    public function handleText(Request $request)
    {
        $text = $request->request->get('text');
        $word = $text;

        return new JsonResponse([
            'word' => $word,
        ]);
    }
}