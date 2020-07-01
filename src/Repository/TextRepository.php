<?php
namespace App\Repository;

use App\Entity\TextItem;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class TextRepository extends EntityRepository
{
    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new ClassMetadata(TextItem::class));
    }

    /**
     * @return array
     */
    public function getTextsWithCount(): array
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->select('t.id, t.text, t.createdAt, SUM(r.count) as number')
            ->leftJoin('t.wordsRelations', 'r')
            ->groupBy('t.id');

        $result = $qb->getQuery()->getResult();

        return $result;
    }

    /**
     * @param TextItem $textItem
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveText(TextItem $textItem): void
    {
        $this->getEntityManager()->persist($textItem);
        $this->getEntityManager()->flush();
    }

    /**
     * @param TextItem $textItem
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteText(TextItem $textItem): void
    {
        $this->getEntityManager()->remove($textItem);
        $this->getEntityManager()->flush();
    }
}
