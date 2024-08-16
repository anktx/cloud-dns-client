<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Tests;

use Anktx\Cloud\Dns\Client\Method\Authenticate\AuthenticationRequest;
use Anktx\Cloud\Dns\Client\Method\Authenticate\Token;
use Anktx\Cloud\Dns\Client\Method\Zones\CreateZoneRequest;
use Anktx\Cloud\Dns\Client\Method\Zones\GetZonesRequest;

final class HttpAdapterTest extends StubApi
{
    public function testSetActiveToken(): void
    {
        $httpAdapter = $this->createHttpAdapter();

        $this->assertNull($httpAdapter->token());

        $token = Token::create((object) $this->tokenArray());

        $httpAdapter->setToken($token);

        $this->assertSame($token, $httpAdapter->token());
    }

    public function testSetExpiredToken(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Token is expired');

        $httpAdapter = $this->createHttpAdapter();

        $this->assertNull($httpAdapter->token());

        $token = Token::create((object) $this->tokenArray(ttl: -1));

        $httpAdapter->setToken($token);
    }

    public function testBearerHeader(): void
    {
        $httpAdapter = $this->createHttpAdapter();

        $bearer = bin2hex(random_bytes(100));

        $token = Token::create((object) $this->tokenArray(token: $bearer));
        $httpAdapter->setToken($token);

        $httpRequest = $httpAdapter->toHttpRequest(new GetZonesRequest(''));

        $this->assertSame('Bearer ' . $bearer, $httpRequest->getHeaderLine('Authorization'));
    }

    public function testAuthenticationRequestUrl(): void
    {
        $httpAdapter = $this->createHttpAdapter();

        $request = new AuthenticationRequest('login', 'password');
        $httpRequest = $httpAdapter->toHttpRequest($request);

        $this->assertSame($request->url(), (string) $httpRequest->getUri());
    }

    public function testGetZonesRequestUrl(): void
    {
        $httpAdapter = $this->createHttpAdapter();

        $request = new GetZonesRequest('');
        $httpRequest = $httpAdapter->toHttpRequest($request);

        $this->assertSame($httpAdapter->baseUrl . '/' . $request->url(), (string) $httpRequest->getUri());
    }

    public function testAuthenticationRequestBody(): void
    {
        $httpAdapter = $this->createHttpAdapter();

        $request = new AuthenticationRequest('login', 'password');
        $httpRequest = $httpAdapter->toHttpRequest($request);

        $query = http_build_query(['grant_type' => 'access_key', 'client_id' => 'login', 'client_secret' => 'password']);

        $this->assertSame($query, $httpRequest->getBody()->getContents());
    }

    public function testCreateZoneRequestBody(): void
    {
        $httpAdapter = $this->createHttpAdapter();

        $request = new CreateZoneRequest('zone', 'parent');
        $httpRequest = $httpAdapter->toHttpRequest($request);

        $json = '{"name":"zone","parentId":"parent"}';

        $this->assertSame($json, $httpRequest->getBody()->getContents());
    }
}
