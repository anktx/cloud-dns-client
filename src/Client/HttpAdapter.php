<?php

declare(strict_types=1);

namespace Anktx\Cloud\Dns\Client\Client;

use Anktx\Cloud\Dns\Client\Method\Authenticate\AuthenticationRequest;
use Anktx\Cloud\Dns\Client\Method\Authenticate\Token;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @internal
 */
final class HttpAdapter
{
    private ?Token $token = null;

    public function __construct(
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        public readonly string $baseUrl = 'https://console.cloud.ru/api',
    ) {
    }

    public function toHttpRequest(Request $request): RequestInterface
    {
        $httpRequest = $this->requestFactory->createRequest(
            $request->method()->name,
            $this->requestUrl($request),
        );

        $httpRequest = $this->httpRequestWithBearer($httpRequest);

        $body = $this->createRequestBody($request);

        return $httpRequest->withBody(
            $this->streamFactory->createStream($body)
        );
    }

    public function toCloudResponse(ResponseInterface $httpResponse): Response
    {
        return new Response(
            body: $httpResponse->getBody()->getContents(),
            httpCode: $httpResponse->getStatusCode(),
        );
    }

    private function requestUrl(Request $request): string
    {
        if ($request instanceof AuthenticationRequest) {
            return $request->url();
        }

        return $this->baseUrl . '/' . $request->url();
    }

    public function setToken(Token $token): void
    {
        if ($token->isExpired(new \DateTimeImmutable(timezone: new \DateTimeZone('UTC')))) {
            throw new \InvalidArgumentException('Token is expired');
        }

        $this->token = $token;
    }

    public function token(): ?Token
    {
        return $this->token;
    }

    /**
     * @throws \JsonException
     */
    private function createRequestBody(Request $request): string
    {
        if (empty($request->data())) {
            return '';
        }

        if ($request instanceof AuthenticationRequest) {
            $body = http_build_query($request->data());
        } else {
            $body = json_encode($request->data(), flags: \JSON_THROW_ON_ERROR);
        }

        return $body;
    }

    private function httpRequestWithBearer(RequestInterface $httpRequest): RequestInterface
    {
        if ($this->token === null) {
            return $httpRequest;
        }

        $httpRequest = $httpRequest->withAddedHeader('Authorization', 'Bearer ' . $this->token->accessToken);
        $httpRequest = $httpRequest->withAddedHeader('Content-Type', 'application/json');

        return $httpRequest;
    }
}
