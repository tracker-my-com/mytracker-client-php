<?php

declare(strict_types=1);

namespace MyTracker\ExportApi;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Raw Data API client
 *
 * @see https://docs.tracker.my.com/api/export-api/raw/about
 */
class RawDataClient extends AbstractClient
{
    /**
     * Create raw export API endpoint URL
     */
    protected const CREATE_REPORT_ENDPOINT_PATH = '/api/raw/v1/export/create.json';

    /**
     * Get raw export API endpoint URL
     */
    protected const GET_REPORT_ENDPOINT_PATH = '/api/raw/v1/export/get.json';

    /**
     * Cancel raw export API endpoint URL
     */
    protected const CANCEL_REPORT_ENDPOINT_PATH = '/api/raw/v1/export/cancel.json';

    /**
     * Creates a request to export raw data to CSV files
     *
     * @see https://docs.tracker.my.com/api/export-api/raw/create
     *
     * @param array $params Array of parameters. Example: ['idApp' => '1', 'idCountry' => '188,200']
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function create(array $params): ResponseInterface
    {
        $request = $this->psr18Client->createRequest('POST', $this->getUrl(self::CREATE_REPORT_ENDPOINT_PATH));
        $request = $request->withBody($this->psr18Client->createStream(http_build_query($params)));
        $request = $this->addAuthorization($request);

        return $this->psr18Client->sendRequest($request);
    }

    /**
     * Retrieves information about the state of a request to export raw data
     *
     * @see https://docs.tracker.my.com/api/export-api/raw/get
     *
     * @param int $idRawExport
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function get(int $idRawExport): ResponseInterface
    {
        $request = $this->psr18Client->createRequest(
            'GET',
            $this->getUrl(self::GET_REPORT_ENDPOINT_PATH) . '?' . http_build_query(['idRawExport' => $idRawExport]),
        );

        $request = $this->addAuthorization($request);

        return $this->psr18Client->sendRequest($request);
    }

    /**
     * Cancels a request to export raw data
     *
     * @see https://docs.tracker.my.com/api/export-api/raw/cancel
     *
     * @param int $idRawExport
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function cancel(int $idRawExport): ResponseInterface
    {
        $request = $this->psr18Client->createRequest(
            'GET',
            $this->getUrl(self::CANCEL_REPORT_ENDPOINT_PATH) . '?' . http_build_query(['idRawExport' => $idRawExport]),
        );

        $request = $this->addAuthorization($request);

        return $this->psr18Client->sendRequest($request);
    }
}
