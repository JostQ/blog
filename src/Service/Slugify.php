<?php


namespace App\Service;


class Slugify
{
    public function generate(string $input) : string
    {
        $result = iconv('utf-8', 'ascii//TRANSLIT', mb_strtolower($input));
        $result = preg_replace('/[^\w ]/', '', $result);
        return preg_replace('/ +/', '-', trim($result));
    }
}
