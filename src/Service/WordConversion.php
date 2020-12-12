<?php
namespace App\Service;

use App\Entity\WordAlias;
use App\Entity\WordItem;

class WordConversion
{
    /**
     * @param WordItem[]
     * @return WordAlias[]
     */
    public function conversion(array $newWords): array
    {
        $aliases = [];
        foreach ($newWords as $word) {
            $alias = $this->comparison($word);
            if (!$alias) {
                continue;
            }
            $aliases[] = new WordAlias($alias, $word);
        }

        return $aliases;
    }

    /**
     * @param WordItem $word
     * @return string
     */
    private function comparison(WordItem $word): ?string
    {
        $alias = '';

        if (substr($word->getName(), -2) === 'ed') {
            if (substr($word->getName(), -3, 1 === 'i')) {
                $alias = substr($word->getName(), 0, strlen($word->getName()) - 3) . 'y';

                return $alias;
            } elseif (substr($word->getName(), -3, 1) === substr($word->getName(), -4, 1)) {
                $alias = substr($word->getName(), 0, strlen($word->getName()) - 3);

                return $alias;
            } else {
                $alias = substr($word->getName(), 0, strlen($word->getName()) - 2);

                return $alias;
            }
        } elseif (substr($word->getName(), -1) === 's') {
            if (substr($word->getName(), -3, 3) === 'ies') {
                $alias = substr($word->getName(), 0, strlen($word->getName()) - 3) . 'y';

                return $alias;
            } elseif (
                substr($word->getName(), -3, 3 === 'oes')
                ||
                substr($word->getName(), -3, 3 === 'xes')
                ||
                substr($word->getName(), -4, 4 === 'sses')
                ||
                substr($word->getName(), -4, 4 === 'shes')
                ||
                substr($word->getName(), -4, 4 === 'ches')
                ||
                substr($word->getName(), -5, 5 === 'tches')
            ) {
                $alias = substr($word->getName(), 0, strlen($word->getName()) - 2);

                return $alias;
            } elseif (substr($word->getName(), -3, 3) === 'ves') {
                $alias = substr($word->getName(), 0, strlen($word->getName()) - 3) . 'fe';

                return $alias;
            } elseif (substr($word->getName(), -2, 2) !== 'es') {
                $alias = substr($word->getName(), 0, strlen($word->getName()) - 1);

                return $alias;
            } else {
                $alias = substr($word->getName(), 0, strlen($word->getName()) - 2);

                return $alias;
            }
        }

        return null;
    }
}
