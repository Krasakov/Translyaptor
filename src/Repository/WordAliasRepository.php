<?php
namespace App\Repository;

use App\Entity\WordAlias;
use App\Entity\WordItem;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class WordAliasRepository extends EntityRepository
{
    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(WordAlias::class));
    }

    /**
     * @param WordAlias $alias
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveAlias(WordAlias $alias): void
    {
        $this->getEntityManager()->persist($alias);
        $this->getEntityManager()->flush();
    }

    /**
     * @param WordItem[] $newWords
     * @return WordAlias[]
     */
    public function getAlias(array $newWords): array
    {
        $wordsIds = [];
        foreach ($newWords as $word) {
            $wordsIds[] = $word->getId();
        }

        if (!$wordsIds) {
            return $wordsIds;
        }

        $qb = $this->createQueryBuilder('a');
        $qb
            ->where($qb->expr()->in('a.wordItem', $wordsIds));

        return $qb->getQuery()->getResult();
    }
}
