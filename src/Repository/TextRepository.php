<?php
namespace App\Repository;

use App\Entity\TextItem;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class TextRepository extends EntityRepository
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
        parent::__construct($em, new ClassMetadata(TextItem::class));
    }

    /**
     * @param $id
     * @return TextItem $text
     */
    public function getTextById($id): TextItem
    {
        $text = $this->find($id);

        return $text;
    }

    /**
     * @return TextItem[] array
     */
    public function getTexts(): array
    {
        $texts = $this->findAll();

        return $texts;
    }

    /**
     * @param TextItem $text
     */
    public function saveText($text): void
    {
        $this->em->persist($text);
        $this->em->flush();
    }
}