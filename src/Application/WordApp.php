<?php
namespace App\Application;

use App\Entity\TextItem;
use App\Entity\TextWordRelation;
use App\Entity\WordItem;
use App\Repository\TextWordRelationRepository;
use App\Repository\WordRepository;
use App\Service\TextDecomposer;

class WordApp
{
    /**
     * @var TextDecomposer
     */
    private $textDecomposer;

    /**
     * @var WordRepository
     */
    private $wordRepo;

    /**
     * @var TextWordRelationRepository
     */
    private $textWordRelationRepo;

    /**
     * @param TextDecomposer $textDecomposer
     * @param WordRepository $wordRepo
     * @param TextWordRelationRepository $textWordRelationRepo
     */
    public function __construct(TextDecomposer $textDecomposer, WordRepository $wordRepo, TextWordRelationRepository $textWordRelationRepo)
    {
        $this->textDecomposer = $textDecomposer;
        $this->wordRepo = $wordRepo;
        $this->textWordRelationRepo = $textWordRelationRepo;
    }

    /**
     * @param TextItem $textItem
     * @return WordItem[]
     */
    public function getWordsForText(TextItem $textItem): array
    {
        return $this->wordRepo->getWords($textItem->getId());
    }

    /**
     * @param TextItem $textItem
     */
    public function processText(TextItem $textItem): void
    {
        $words = $this->textDecomposer->splitTextIntoWords($textItem);
        $this->wordRepo->saveNotExistedWords($words);

        foreach ($words as $word) {
            /** @var WordItem $word */
            $word = $this->wordRepo->findOneBy(['name' => $word->getName()]);
            $relation = new TextWordRelation($textItem, $word);
            $this->textWordRelationRepo->createRelationOrIncreaseCounter($relation);
        }
    }
}