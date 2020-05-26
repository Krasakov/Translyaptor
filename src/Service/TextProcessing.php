<?php
namespace App\Service;

class TextProcessing
{
    public function getHandlerText($text)
    {
        $words = preg_split("/[\s,.\d]+/", strtolower(trim($text)));

        return $words;
    }

}