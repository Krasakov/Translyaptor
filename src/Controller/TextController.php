<?php
namespace App\Controller;

use App\Application\TextApp;
use App\Application\WordApp;
use App\Entity\TextItem;
use App\Exception\ValidationException;
use App\Form\TextFormType;
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
     * @throws \Exception
     */
    public function createWithForm(Request $request, TextApp $textApp): Response
    {
        $form = $this->createForm(TextFormType::class, new TextItem(''));

        if ($request->isMethod('POST')) {
            try {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    /** @var TextItem $textItem */
                    $textItem = $form->getData();
                    $textItem = $textApp->processText($textItem->getText());

                    $this->addFlash('success', 'Text saved successful!');

                    return $this->redirectToRoute('text_details', ['id' => $textItem->getId()]);
                }
            } catch (ValidationException $e) {
                foreach ($e->getMessages() as $message) {
                    $this->addFlash('danger', $message);
                }

                return $this->redirectToRoute('create_text');
            } catch (\Throwable $e) {
                    $this->addFlash('danger', 'Something went wrong!' . $e->getMessage());

                return $this->redirectToRoute('create_text');
            }
        }

        return $this->render('work_with_text.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route(path="/list", methods={"GET"}, name="text_list")
     * @param TextApp $textApp
     * @return Response
     */
    public function list(TextApp $textApp): Response
    {
        $texts = $textApp->getCountWordsForText();

        return $this->render('list_text.html.twig', [
            'texts' => $texts,
        ]);
    }

    /**
     * @Route(path="/{id}/delete", methods={"GET"}, name="text_delete")
     * @param TextApp $textApp
     * @param TextItem $textItem
     * @return Response
     * @throws \Throwable
     */
    public function delete(TextApp $textApp, TextItem $textItem): Response
    {
        $textApp->deleteTextWithWords($textItem);

        return $this->redirectToRoute('text_list');
    }

    /**
     * @Route(path="/{id}", methods={"GET"}, name="text_details", requirements={"id":"\d+"})
     * @param WordApp $wordApp
     * @param TextItem $textItem
     * @return Response
     */
    public function details(WordApp $wordApp, TextItem $textItem): Response
    {
        $wordsAggregator = $wordApp->getSeparatedWordsForText($textItem);
        $alias = $wordApp->getAliasForText($textItem);

        return $this->render('details_text.html.twig', [
            'textItem' => $textItem,
            'wordsAggregator' => $wordsAggregator,
            'aliases' => $alias,
        ]);
    }
}
