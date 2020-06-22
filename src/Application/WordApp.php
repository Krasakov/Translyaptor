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
     * @return WordItem[]|array
     */
    public function getListWords(): array
    {
       return $this->wordRepo->findAll();
    }

    /**
     * @param TextItem $textItem
     * @return WordItem[]
     */
    public function getWordsForText(TextItem $textItem): array
    {
        return $this->wordRepo->getWordsFromText($textItem->getId());
    }

    /**
     * @param TextItem $textItem
     * @return WordAggregator
     */
    public function getSeparatedWordsForText(TextItem $textItem): WordAggregator
    {
        return new WordAggregator(
            $this->wordRepo->getNewWordsForText($textItem),
            $this->wordRepo->getExistedWordsForText($textItem),
            $this->wordRepo->getBlacklistedWordsForText($textItem)
        );
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

    /**
     * @param WordItem $wordItem
     */
    public function moveToBlackList(WordItem $wordItem)
    {
        $wordItem->markBlackListed();
        $this->wordRepo->save($wordItem);
    }

    /**
     * @param WordItem $wordItem
     */
    public function moveFromBlackList(WordItem $wordItem)
    {
        $wordItem->markNotBlackListed();
        $this->wordRepo->save($wordItem);
    }

    /**
     * @param int[] $wordIds
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function moveToBlackListBulk(array $wordIds): void
    {
        if (empty($wordIds)) {
            return;
        }
        $this->wordRepo->updateBlackListStatus($wordIds, true);
    }

    /**
     * @param int[] $wordIds
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function moveFromBlackListBulk(array $wordIds): void
    {
        if (empty($wordIds)) {
            return;
        }
        $this->wordRepo->updateBlackListStatus($wordIds, false);
    }

    public function deleteWordsOfText(): void
    {
        $this->wordRepo->deleteWords();
    }
}