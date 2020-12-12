<?php
namespace App\Service;

use App\Application\WordCollection;
use App\Entity\TextItem;
use App\Entity\WordItem;

class TextDecomposer
{
    /**
     * @param TextItem $textItem
     * @return WordCollection
     */
    public function splitTextIntoWords(TextItem $textItem): WordCollection
    {
        $splitWords = preg_split("/[^a-z]/is", strtolower(trim($textItem->getText())));

        $words = new WordCollection();
        foreach ($splitWords as $word) {
            if (strlen($word) <= 2) {
                continue;
            }

            $words->addWord(new WordItem($word));
        }

        return $words;
    }
}
