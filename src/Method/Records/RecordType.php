<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Method\Records;

enum RecordType
{
    case A;
    case TXT;
    case CNAME;
    case SRV;
    case MX;
    case AAAA;
    case NS;
    case SOA;

    public static function from(string $type): self
    {
        return match ($type) {
            'A' => self::A,
            'TXT' => self::TXT,
            'CNAME' => self::CNAME,
            'SRV' => self::SRV,
            'MX' => self::MX,
            'AAAA' => self::AAAA,
            'NS' => self::NS,
            'SOA' => self::SOA,
        };
    }
}
