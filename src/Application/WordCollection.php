<?php

namespace App\Application;

use App\Entity\WordItem;
use Symfony\Component\Validator\Constraints as Assert;

class WordCollection
{
    /**
     * @var WordItem[]
     * @Assert\NotBlank(message="text does not contain words")
     */
    private $words;

    public function __construct()
    {
        $this->words = [];
    }

    /**
     * @param WordItem $word
     */
    public function addWord(WordItem $word)
    {
        $this->words[] = $word;
    }

    /**
     * @return WordItem[]
     */
    public function getWords(): array
    {
        return $this->words;
    }
}
