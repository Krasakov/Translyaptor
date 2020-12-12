<?php
namespace App\Controller;

use App\Application\WordApp;
use App\Entity\TextItem;
use App\Entity\WordItem;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/word")
 */
class WordController extends AbstractController
{
    /**
     * @Route(path="/show", methods={"GET"}, name="words_show")
     * @param WordApp $wordApp
     * @return Response
     */
    public function showWords(WordApp $wordApp): Response
    {
        $words = $wordApp->getListWords();

        return $this->render('list_words.html.twig', ['words' => $words]);
    }

    /**
     * @Route(path="/{text}/{word}/move-to-blacklist", methods={"GET"}, name="move_to_black_list")
     * @param WordApp $wordApp
     * @param TextItem $text
     * @param WordItem $word
     * @return Response
     */
    public function moveToBlackList(WordApp $wordApp, TextItem $text, WordItem $word): Response
    {
        $wordApp->moveToBlackList($word);

        return $this->redirectToRoute('text_details', ['id' => $text->getId()]);
    }

    /**
     * @Route(path="/{text}/{word}/move-from-blacklist", methods={"GET"}, name="move_from_black_list")
     * @param WordApp $wordApp
     * @param TextItem $text
     * @param WordItem $word
     * @return Response
     */
    public function moveFromBlackList(WordApp $wordApp, TextItem $text, WordItem $word): Response
    {
        $wordApp->moveFromBlackList($word);

        return $this->redirectToRoute('text_details', ['id' => $text->getId()]);
    }

    /**
     * @Route(path="/{text}/move-to-blacklist", methods={"POST"}, name="move_to_black_list_bulk")
     * @param Request $request
     * @param WordApp $wordApp
     * @param TextItem $text
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function moveToBlackListBulk(Request $request, WordApp $wordApp, TextItem $text): Response
    {
        $wordIds = $request->request->get('wordIds', []);
        $wordApp->moveToBlackListBulk($wordIds);

        return $this->redirectToRoute('text_details', ['id' => $text->getId()]);
    }

    /**
     * @Route(path="/{text}/move-from-blacklist", methods={"POST"}, name="move_from_black_list_bulk")
     * @param Request $request
     * @param WordApp $wordApp
     * @param TextItem $text
     * @return Response
     * @return RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function moveFromBlackListBulk(Request $request, WordApp $wordApp, TextItem $text): RedirectResponse
    {
        $wordIds = $request->request->get('wordIds', []);
        $wordApp->moveFromBlackListBulk($wordIds);

        return $this->redirectToRoute('text_details', ['id' => $text->getId()]);
    }
}
