<?php
namespace App\Repository;

use App\Application\WordCollection;
use App\Entity\TextItem;
use App\Entity\WordItem;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class WordRepository extends EntityRepository
{
    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new Mapping\ClassMetadata(WordItem::class));
    }

    /**
     * @param int $textId
     * @return WordItem[]
     */
    public function getWordsFromText(int $textId): array
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->leftJoin('w.textsRelations', 'r')
            ->where('r.textItem = :text_id')
            ->andWhere('w.blackListed = 0')
            ->setParameter('text_id', $textId);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param TextItem $textItem
     * @return WordItem[]
     */
    public function getNewWordsForText(TextItem $textItem):array
    {
        $subQuery = $this->createQueryBuilder('sub_w');
        $subQuery
            ->leftJoin('sub_w.textsRelations', 'sub_r')
            ->where('sub_r.textItem = :text_id');

        $qb = $this->createQueryBuilder('w');
        $qb
            ->leftJoin('w.textsRelations', 'r')
            ->where($qb->expr()->in('w.id', $subQuery->getDQL()))
            ->andWhere('w.blackListed = 0')
            ->groupBy('w.id')
            ->having('COUNT(r.textItem) = 1')
            ->setParameter('text_id', $textItem->getId());

        return $qb->getQuery()->getResult();
    }

    /**
     * @param TextItem $textItem
     * @return WordItem[]
     */
    public function getExistedWordsForText(TextItem $textItem):array
    {
        $subQuery = $this->createQueryBuilder('sub_w');
        $subQuery
            ->leftJoin('sub_w.textsRelations', 'sub_r')
            ->where('sub_r.textItem = :text_id');

        $qb = $this->createQueryBuilder('w');
        $qb
            ->leftJoin('w.textsRelations', 'r')
            ->where($qb->expr()->in('w.id', $subQuery->getDQL()))
            ->andWhere('w.blackListed = 0')
            ->groupBy('w.id')
            ->having('COUNT(r.textItem) > 1')
            ->setParameter('text_id', $textItem->getId());

        return $qb->getQuery()->getResult();
    }

    /**
     * @param TextItem $textItem
     * @return WordItem[]
     */
    public function getBlacklistedWordsForText(TextItem $textItem): array
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->leftJoin('w.textsRelations', 'r')
            ->where('r.textItem = :text_id')
            ->andWhere('w.blackListed = 1')
            ->setParameter('text_id', $textItem->getId());

        return $qb->getQuery()->getResult();
    }

    /**
     * @param WordCollection $wordCollection
     * @throws DBALException
     */
    public function saveNotExistedWords(WordCollection $wordCollection): void
    {
        $values = [];
        foreach ($wordCollection->getWords() as $word) {
            $values[] = $word->getName();
        }

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare('
            INSERT INTO word_item(`name`)
            VALUES ' . implode(',', array_fill(0, count($values), '(?)')) . '
            ON DUPLICATE KEY UPDATE name = name
        ');

        $stmt->execute($values);
    }

    /**
     * @param WordItem $wordItem
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(WordItem $wordItem)
    {
       $this->getEntityManager()->persist($wordItem);
       $this->getEntityManager()->flush();
    }

    public function deleteWords(): void
    {
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare('
            DELETE w FROM word_item AS w
            LEFT JOIN text_word_relation AS r ON w.id = r.word_item_id
            WHERE r.word_item_id IS NULL
        ');

        $stmt->execute();
    }

    /**
     * @param int[] $wordIds
     * @param bool $isBlackListed
     */
    public function updateBlackListStatus(array $wordIds, bool $isBlackListed): void
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->update(WordItem::class, 'w')
            ->set('w.blackListed', ':black_listed')
            ->where($qb->expr()->in('w.id', $wordIds))
            ->setParameter('black_listed', $isBlackListed);

        $qb->getQuery()->execute();
    }
}
