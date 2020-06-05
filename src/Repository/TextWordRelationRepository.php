<?php
namespace App\Repository;

use App\Entity\TextItem;
use App\Entity\TextWordRelation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

class TextWordRelationRepository extends EntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, new Mapping\ClassMetadata(TextWordRelation::class));
    }

    /**
     * @param TextWordRelation $relation
     */
    public function createRelationOrIncreaseCounter($relation): void
    {
        $textItemId = $relation->getText()->getId();
        $wordItemId = $relation->getWord()->getId();

        $conn = $this->em->getConnection();
        $stmt = $conn->prepare('
            INSERT INTO word_text_relation(text_item_id, word_item_id, `count`)
            VALUES (:textItemId, :wordItemId, 1)
            ON DUPLICATE `count` = `count` + 1
        ');

        $stmt->bindValue('textItemId', $textItemId);
        $stmt->bindValue('wordItemId', $wordItemId);

        $stmt->execute();
    }
}