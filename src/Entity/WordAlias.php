<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordAliasRepository")
 */
class WordAlias
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var WordItem
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\WordItem", inversedBy="wordAlias")
     * @ORM\JoinColumn(name="word_item_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $wordItem;

    /**
     * @param string $name
     * @param WordItem $wordItem
     */
    public function __construct(string $name, WordItem $wordItem)
    {
        $this->name = $name;
        $this->wordItem = $wordItem;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return WordItem
     */
    public function getWordItem(): WordItem
    {
        return $this->wordItem;
    }
}
