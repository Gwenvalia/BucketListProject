<?php

namespace App\Helper;

class Censurator {

    public function purify(string $string): string
    {

        $file = '../data/censured_words.txt';
        $censured_words = file($file);
        foreach ($censured_words as $word) {
            $word = str_ireplace(PHP_EOL,'', $word);
            $replacement = str_repeat('*', strlen($word));
            $string = str_ireplace($word, $replacement, $string);
        }

        return $string;
    }
}