<?php
namespace App\Application;

use App\Entity\TextItem;
use App\Entity\WordItem;
use App\Repository\TextRepository;
use Doctrine\ORM\EntityManagerInterface;

class TextApp
{
    /**
     * @var TextRepository
     */
    private $textRepo;

    /**
     * @var WordApp
     */
    private $wordApp;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param TextRepository $textRepo
     * @param WordApp $wordApp
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, TextRepository $textRepo, WordApp $wordApp)
    {
        $this->textRepo = $textRepo;
        $this->wordApp = $wordApp;
        $this->em = $em;
    }

    /**
     * @param $text
     * @return TextItem
     */
    public function processText($text): TextItem
    {
        $textItem = new TextItem($text);

        $this->em->beginTransaction();
        try {
            $this->textRepo->saveText($textItem);
            $this->wordApp->processText($textItem);

            $this->em->commit();

            return $textItem;
        } catch (\Throwable $e) {
            $this->em->rollback();

            throw $e;
        }
    }
}