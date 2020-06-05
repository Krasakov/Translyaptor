<?php
namespace App\Controller;

use App\Application\TextApp;
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
     * @param TextApp $textApp
     * @return Response
     */
    public function create(Request $request, TextApp $textApp)
    {
        if ($request->isMethod('POST')) {
            $text = $request->request->get('text');
            $textApp->processText($text);

            return $this->render('work_with_text.html.twig');
        }

        return $this->render('work_with_text.html.twig');
    }
}