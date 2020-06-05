<?php
namespace App\Service;

use App\Entity\TextItem;
use App\Entity\WordItem;

class TextDecomposer
{
    /**
     * @param TextItem $textItem
     * @return WordItem[]
     */
    public function splitTextIntoWords(TextItem $textItem): array
    {
        $words = preg_split("/[\s,.]+/", strtolower(trim($textItem->getText())));

        $wordsObj = [];
        foreach ($words as $word) {
           $wordsObj[] = new WordItem($word);
        }

        return $wordsObj;
    }
}