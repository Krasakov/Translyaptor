<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class TextWordRelation
{
    /**
     * @var TextItem
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\TextItem", inversedBy="wordsRelations")
     * @ORM\JoinColumn(name="text_item_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $textItem;

    /**
     * @var WordItem
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\WordItem", inversedBy="textsRelations")
     * @ORM\JoinColumn(name="word_item_id", referencedColumnName="id", nullable=false)
     */
    private $wordItem;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $count = 1;

    /**
     * @param TextItem $textItem
     * @param WordItem $wordItem
     */
    public function __construct(TextItem $textItem, WordItem $wordItem)
    {
        $this->textItem = $textItem;
        $this->wordItem = $wordItem;
    }

    /**
     * @return TextItem
     */
    public function getText(): TextItem
    {
        return $this->textItem;
    }

    /**
     * @return WordItem
     */
    public function getWord(): WordItem
    {
        return $this->wordItem;
    }
}
