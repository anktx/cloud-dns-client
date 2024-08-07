<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Client;

enum HttpMethod
{
    case GET;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;
    case HEAD;
}
