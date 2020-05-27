<?php
namespace App\Controller;

use App\Service\TextProcessing;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/text")
 */
class TextController extends AbstractController
{
    /**
     * @Route(path="/create", methods={"GET", "POST"}, name="create_text")
     * @param Request $request
     * @param TextProcessing $textProcessing
     * @return Response
     */
    public function create(Request $request, TextProcessing $textProcessing)
    {
        if ($request->isMethod('POST')) {
            $text = $request->request->get('text');
            $words = $textProcessing->processing($text);

        }

        return $this->render('work_with_text.html.twig');
    }
}