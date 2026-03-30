<?php

trait CensorHelper 
{
    protected function censorProfanity(string $text): string 
    {
        $badWords = ['fuck', 'shit', 'bitch', 'damn', 'ass', 'fucker', 'pussy', 'cock', 'dick'];
        foreach ($badWords as $word) {
            $text = str_ireplace($word, str_repeat('*', strlen($word)), $text);
        }
        return trim($text);
    }
}

