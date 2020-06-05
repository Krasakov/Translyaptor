<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class TextWordRelation
{
    /**
     * @var TextItem
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\TextItem", inversedBy="words")
     * @ORM\JoinColumn(name="text_item_id", referencedColumnName="id", nullable=false)
     */
    private $textItem;

    /**
     * @var WordItem
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\WordItem", inversedBy="texts")
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