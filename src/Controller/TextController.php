<?php
namespace App\Controller;

use App\Application\TextApp;
use App\Application\WordApp;
use App\Entity\TextItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TextController extends AbstractController
{
    /**
     * @Route(path="/text/create", methods={"GET", "POST"}, name="create_text")
     * @param Request $request
     * @param TextApp $textApp
     * @return Response
     */
    public function create(Request $request, TextApp $textApp)
    {
        if ($request->isMethod('POST')) {
            $text = $request->request->get('text');
            $textItem = $textApp->processText($text);

            return $this->redirectToRoute('text_details', ['id' => $textItem->getId()]);
        }

        return $this->render('work_with_text.html.twig');
    }

    /**
     * @Route(path="/", methods={"GET"}, name="text_list")
     * @param TextApp $textApp
     * @return Response
     */
    public function list(TextApp $textApp)
    {
        $texts = $textApp->getCountWordsForText();

        return $this->render('list_text.html.twig', [
            'texts' => $texts,
        ]);
    }

    /**
     * @Route(path="/text/{id}/delete", methods={"GET"}, name="text_delete")
     * @param TextApp $textApp
     * @param TextItem $textItem
     * @return Response
     * @throws \Throwable
     */
    public function delete(TextApp $textApp, TextItem $textItem)
    {
        $textApp->deleteTextWithWords($textItem);

        return $this->redirectToRoute('text_list');
    }

    /**
     * @Route(path="/text/{id}", methods={"GET"}, name="text_details", requirements={"id":"\d+"})
     * @param WordApp $wordApp
     * @param TextItem $textItem
     * @return Response
     */
    public function details(WordApp $wordApp, TextItem $textItem)
    {
        $wordsAggregator = $wordApp->getSeparatedWordsForText($textItem);

        return $this->render('details_text.html.twig', [
            'textItem' => $textItem,
            'wordsAggregator' => $wordsAggregator,
        ]);
    }
}