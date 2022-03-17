<?php

declare(strict_types=1);

namespace src\traits;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

trait Serialize
{

    public function bootstrap()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder(), new CsvEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }

    public function serialize($data, $type = 'json')
    {
        $serializer = $this->bootstrap();
        return $serializer->serialize($data, $type);
    }

    public function deserialize($data, $type, $format)
    {
        $serializer = $this->bootstrap();
        $result = match ($type) {
            "json" => $serializer->deserialize(
                $data,
                $type,
                $format,
                ['json_encode_options' => JSON_PRESERVE_ZERO_FRACTION]
            ),
            default => $serializer->deserialize($data, $type, $format)
        };
        return $result;
    }
}
