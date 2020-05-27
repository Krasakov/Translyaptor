<?php
namespace App\Service;

class TextProcessing
{
    public function processing($text)
    {
        $words = preg_split("/[\s,.]+/", strtolower(trim($text)));

        return $words;
    }

}