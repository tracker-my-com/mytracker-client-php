<?php

declare(strict_types=1);

namespace MyTracker\ExportApi;

use Psr\Http\Message\ResponseInterface;

/**
 * Quotas API client
 *
 * @see https://docs.tracker.my.com/api/export-api/quotas/
 */
class QuotasClient extends AbstractClient
{
    /**
     * GET quotas API endpoint URL
     */
    protected const GET_QUOTAS_ENDPOINT_PATH = '/api/open/user/v1/quotas/get.json';

    /**
     * Review quotas
     *
     * Retrieves information on the number of quotas
     *
     * @see https://docs.tracker.my.com/api/export-api/quotas/#check_quotas
     *
     * @return ResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function get(): ResponseInterface
    {
        $request = $this->psr18Client->createRequest('GET', $this->getUrl(self::GET_QUOTAS_ENDPOINT_PATH));
        $request = $this->addAuthorization($request);

        return $this->psr18Client->sendRequest($request);
    }
}
