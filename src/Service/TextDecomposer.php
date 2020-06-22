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
        $splitWords = preg_split("/[^a-z]/is", strtolower(trim($textItem->getText())));

        $words = [];
        foreach ($splitWords as $word) {
            if (strlen($word) <= 2) {
                continue;
            }

            $words[] = new WordItem($word);
        }

        return $words;
    }
}