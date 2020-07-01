<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordRepository")
 */
class WordItem
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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default": 0})
     */
    private $blackListed = false;

    /**
     * @var ArrayCollection|TextWordRelation[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\TextWordRelation", mappedBy="wordItem")
     */
    private $textsRelations;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->textsRelations = new ArrayCollection();
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
     * @return bool
     */
    public function isBlackList(): bool
    {
        return $this->blackListed;
    }

    public function markBlackListed(): void
    {
        $this->blackListed = true;
    }

    public function markNotBlackListed(): void
    {
        $this->blackListed = false;
    }
}
