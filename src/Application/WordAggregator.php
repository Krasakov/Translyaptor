<?php

namespace App\Application;

use App\Entity\WordItem;

class WordAggregator
{
    /**
     * @var WordItem[]
     */
    private $newWords;

    /**
     * @var WordItem[]
     */
    private $existedWords;

    /**
     * @var WordItem[]
     */
    private $blacklistedWords;

    /**
     * @param WordItem[]    $newWords
     * @param WordItem[]    $existedWords
     * @param WordItem[]    $blacklistedWords
     */
    public function __construct(array $newWords, array $existedWords, array $blacklistedWords)
    {
        $this->newWords = $newWords;
        $this->existedWords = $existedWords;
        $this->blacklistedWords = $blacklistedWords;
    }

    /**
     * @return WordItem[]
     */
    public function getNewWords(): array
    {
        return $this->newWords;
    }

    /**
     * @return WordItem[]
     */
    public function getExistedWords(): array
    {
        return $this->existedWords;
    }

    /**
     * @return WordItem[]
     */
    public function getBlacklistedWords(): array
    {
        return $this->blacklistedWords;
    }
}
