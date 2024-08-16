<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client;

use Anktx\Cloud\Dns\Client\Client\FailResult;
use Anktx\Cloud\Dns\Client\Client\HttpAdapter;
use Anktx\Cloud\Dns\Client\Client\Request;
use Anktx\Cloud\Dns\Client\Method\Authenticate\AuthenticationRequest;
use Anktx\Cloud\Dns\Client\Method\Authenticate\Token;
use Anktx\Cloud\Dns\Client\Method\Records\CreateRecordRequest;
use Anktx\Cloud\Dns\Client\Method\Records\DeleteRecordRequest;
use Anktx\Cloud\Dns\Client\Method\Records\GetRecordRequest;
use Anktx\Cloud\Dns\Client\Method\Records\GetRecordsRequest;
use Anktx\Cloud\Dns\Client\Method\Records\Record;
use Anktx\Cloud\Dns\Client\Method\Records\Records;
use Anktx\Cloud\Dns\Client\Method\Records\RecordType;
use Anktx\Cloud\Dns\Client\Method\Zones\CreateZoneRequest;
use Anktx\Cloud\Dns\Client\Method\Zones\DeleteZoneRequest;
use Anktx\Cloud\Dns\Client\Method\Zones\GetZoneRequest;
use Anktx\Cloud\Dns\Client\Method\Zones\GetZonesRequest;
use Anktx\Cloud\Dns\Client\Method\Zones\Zone;
use Anktx\Cloud\Dns\Client\Method\Zones\Zones;
use Psr\Http\Client\ClientInterface;

final readonly class CloudDnsApi
{
    public function __construct(
        private ClientInterface $client,
        private HttpAdapter $httpAdapter,
    ) {}

    public function authenticate(string $clientId, string $clientSecret): FailResult|Token
    {
        return $this->request(
            new AuthenticationRequest($clientId, $clientSecret),
        );
    }

    public function getZones(string $parentId): FailResult|Zones
    {
        return $this->request(
            new GetZonesRequest($parentId),
        );
    }

    public function getZone(string $id): FailResult|Zone
    {
        return $this->request(
            new GetZoneRequest($id),
        );
    }

    public function createZone(string $name, string $parentId): FailResult|Zone
    {
        return $this->request(
            new CreateZoneRequest(name: $name, parentId: $parentId),
        );
    }

    public function deleteZone(string $id): FailResult|true
    {
        return $this->request(
            new DeleteZoneRequest($id),
        );
    }

    public function getRecords(string $zoneId): FailResult|Records
    {
        return $this->request(
            new GetRecordsRequest($zoneId),
        );
    }

    public function getRecord(string $zoneId, RecordType $type, string $name): FailResult|Record
    {
        return $this->request(
            new GetRecordRequest($zoneId, $type, $name),
        );
    }

    /**
     * @param string[] $values
     */
    public function createRecord(string $zoneId, RecordType $type, string $name, int $ttl, array $values): FailResult|Record
    {
        return $this->request(
            new CreateRecordRequest(zoneId: $zoneId, name: $name, ttl: $ttl, type: $type, values: $values),
        );
    }

    public function deleteRecord(string $zoneId, RecordType $type, string $name): FailResult|true
    {
        return $this->request(
            new DeleteRecordRequest(zoneId: $zoneId, type: $type, name: $name),
        );
    }

    public function request(Request $request): mixed
    {
        $httpRequest = $this->httpAdapter->toHttpRequest($request);

        $httpResponse = $this->client->sendRequest($httpRequest);

        $response = $this->httpAdapter->toCloudResponse($httpResponse);

        if ($response->httpCode !== 200) {
            return new FailResult($request, $response);
        }

        return self::createResponseFromJson($response->body, $request->resultType());
    }

    public static function createResponseFromJson(string $body, string $resultType): mixed
    {
        try {
            $std = json_decode($body, flags: \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return \call_user_func([$resultType, 'create'], $std);
    }
}
