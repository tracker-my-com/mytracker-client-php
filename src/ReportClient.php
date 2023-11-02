<?php

declare(strict_types=1);

namespace MyTracker\ExportApi;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Report API client
 *
 * @see https://docs.tracker.my.com/api/export-api/report/about
 */
class ReportClient extends AbstractClient
{
    /**
     * Endpoint URL for creating a report
     */
    protected const CREATE_REPORT_ENDPOINT_PATH = '/api/report/v1/file/create.json';

    /**
     * Endpoint URL for getting a report
     */
    protected const GET_REPORT_ENDPOINT_PATH = '/api/report/v1/file/get.json';

    /**
     * Creates a request to export report
     *
     * @see https://docs.tracker.my.com/api/export-api/report/create
     *
     * @param array $params Array of parameters. Example: ['settings' => ['idCurrency' => '840', 'precision' => '2']]
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
     * Gets information about the state of a request and download links for successfully created report files
     *
     * @see https://docs.tracker.my.com/api/export-api/report/get
     *
     * @param int $idReportFile
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function get(int $idReportFile): ResponseInterface
    {
        $request = $this->psr18Client->createRequest(
            'GET',
            $this->getUrl(self::GET_REPORT_ENDPOINT_PATH) . '?' . http_build_query(['idReportFile' => $idReportFile]),
        );

        $request = $this->addAuthorization($request);

        return $this->psr18Client->sendRequest($request);
    }
}
