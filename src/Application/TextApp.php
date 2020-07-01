<?php
namespace App\Application;

use App\Entity\TextItem;
use App\Exception\ValidationException;
use App\Repository\TextRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param TextRepository $textRepo
     * @param WordApp $wordApp
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EntityManagerInterface $em,
        TextRepository $textRepo,
        WordApp $wordApp,
        ValidatorInterface $validator
    )
    {
        $this->textRepo = $textRepo;
        $this->wordApp = $wordApp;
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * @return array
     */
    public function getCountWordsForText(): array
    {
        return $this->textRepo->getTextsWithCount();
    }

    /**
     * @return TextItem[]|array
     */
    public function listText(): array
    {
        return $this->textRepo->findAll();
    }

    /**
     * @param string $text
     * @return TextItem
     * @throws \Throwable
     */
    public function processText(string $text): TextItem
    {
        $textItem = new TextItem($text);
        $constraints = $this->validator->validate($textItem);

        if ($constraints->count()) {
            throw new ValidationException($constraints);
        }

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

    /**
     * @param TextItem $textItem
     * @throws \Throwable
     */
    public function deleteTextWithWords(TextItem $textItem): void
    {
        $this->em->beginTransaction();
        try {
            $this->textRepo->deleteText($textItem);
            $this->wordApp->deleteWordsOfText();

            $this->em->commit();
        } catch (\Throwable $e) {
            $this->em->rollback();

            throw $e;
        }
    }
}
