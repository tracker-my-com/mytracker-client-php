<?php

declare(strict_types=1);

namespace MyTracker\ExportApi;

use Http\Discovery\Psr18Client;
use Psr\Http\Message\RequestInterface;

/**
 * Abstract Client
 *
 * Code common to all concrete clients
 */
abstract class AbstractClient
{
    /**
     * API credentials are available in your profile
     *
     * @see https://docs.tracker.my.com/api/export-api/access
     *
     * @param string                      $appUserId
     * @param string                      $apiSecretKey
     * @param \Http\Discovery\Psr18Client $psr18Client
     * @param string                      $baseUrl
     */
    public function __construct(
        protected string $appUserId,
        protected string $apiSecretKey,
        protected Psr18Client $psr18Client,
        protected string $baseUrl = 'https://tracker.my.com',
    ) {
    }

    /**
     * Add authorization params to the request object
     *
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function addAuthorization(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('Authorization', $this->getAuthString($request));
    }

    /**
     * Generate the Authorization header value
     *
     * @see https://docs.tracker.my.com/api/export-api/authentication
     *
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return string
     */
    protected function getAuthString(RequestInterface $request): string
    {
        $method = $request->getMethod();
        $data = $request->getMethod() === 'POST' ? $request->getBody()->__toString() : '';
        $string = sprintf('%s&%s&%s', $method, rawurlencode($request->getUri()->__toString()), rawurlencode($data));
        $signature = base64_encode(hash_hmac('sha1', $string, $this->apiSecretKey, true));

        return "AuthHMAC {$this->appUserId}:$signature";
    }

    /**
     * Get URL by path
     *
     * @param string $path Path
     *
     * @return string
     */
    protected function getUrl(string $path): string
    {
        return $this->baseUrl . $path;
    }
}
