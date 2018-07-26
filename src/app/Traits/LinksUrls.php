<?php

namespace Droplister\JobCore\App\Traits;

trait LinksUrls
{
    /**
     * Plain-Text -> HTML
     * http://code.seebz.net/p/autolink-php/
     *
     * @return array
     */
    public function urlsToHtml($str, $attributes=array())
    {
        $str = trim($str);
        $attrs = '';
        foreach ($attributes as $attribute => $value) {
            $attrs .= " {$attribute}=\"{$value}\"";
        }

        $str = ' ' . $str;
        $str = preg_replace(
            '`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
            '$1<a href="$2"'.$attrs.'>$2</a>',
            $str
        );
        $str = substr($str, 1);
        
        return $str;
    }
}