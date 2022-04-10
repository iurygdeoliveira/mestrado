<?php

declare(strict_types=1);

namespace src\traits;

trait XmlArray
{
    public function xml2array_parse($xml)
    {
        $response = [];

        foreach ($xml->children() as $parent => $child) {

            $atributtes = [];
            if ($xml->attributes()) {
                foreach ($xml->attributes() as $key => $value) {
                    $atributtes[$key] = $value;
                }
                $response = array_merge($response, $atributtes);
            }
            $response["$parent"] = $this->xml2array_parse($child) ? $this->xml2array_parse($child) : "$child";
        }
        return $response;
    }
}
