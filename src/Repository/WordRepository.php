<?php
namespace App\Repository;

use App\Entity\TextWordRelation;
use App\Entity\WordItem;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

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
    public function getWords(int $textId): array
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->leftJoin(TextWordRelation::class, 'r')
            ->where('r.textItem = :text_id')
            ->andWhere('w.blackListed = 0')
            ->setParameter('text_id', $textId);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param WordItem[] $words
     */
    public function saveNotExistedWords($words): void
    {
        $values = [];
        foreach ($words as $word) {
            $values[] = $word->getName();
        }

        $conn = $this->em->getConnection();
        $stmt = $conn->prepare('
            INSERT INTO word_item(`name`)
            VALUES ' . implode(',', array_fill(0, count($values), '(?)')) . '
            ON DUPLICATE IGNORE 
        ');

        $stmt->execute($values);
    }
}