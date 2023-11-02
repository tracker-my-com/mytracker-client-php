## ✨ Features

- Thin & minimal HTTP client to interact with MyTracker's API
- Supports php `^8.0`.
- Adheres to PSR-18, PSR-17 and PSR-7 principles under the hood.

## 💡 Getting Started

First, install MyTracker PHP API Client via the [composer](https://getcomposer.org/) package manager:
```bash
composer require tracker-my-com/mytracker-client-php
```

Then, use `\MyTracker\ExportApi\*Client` classes in your code:

```php
use Http\Discovery\Psr18Client;
use MyTracker\ExportApi\QuotasClient;
use MyTracker\ExportApi\RawDataClient;

$psr18Client = new Psr18Client();

$quotasClient = new QuotasClient('appUserId', 'apiSecretKey', $psr18Client);
$result = $quotasClient->get();
echo $result->getBody();

$rawDataClient = new RawDataClient('appUserId', 'apiSecretKey', $psr18Client);
$result = $rawDataClient->create([
    'event' => 'payments',
    'selectors' => 'idCountry,waid,idAccount,iosVendorId',
    'dateTo' => '2017-11-30',
    'dateFrom' => '2017-11-02',
    'timezone' => 'Europe/Moscow',
]);
echo $result->getBody();

$result = $rawDataClient->get(123 /* idRawExport from the previous request */);
echo $result->getBody();

$reportClient = new ReportClient('appUserId', 'apiSecretKey', $psr18Client);
$result = $reportClient->create([
    'settings' => [
        'filter' => [
            'date' => [
                'from' => '2020-07-10',
                'to' => '2020-07-17',
            ],
        ],
        'selectors' => 'idApp,countInstall',
        'idCurrency' => 643,
        'tz' => 'Europe/Moscow',
        'precision' => 2,
        'retIndent' => 3600,
    ]
]);

$result = $reportClient->get(123 /* idReportFile from the previous request */);
echo $result->getBody();
```

For full documentation, visit the **[MyTracker Export API docs](https://docs.tracker.my.com/api/export-api/about)**.

## ❓ Troubleshooting

Encountering an issue? [Contact us!](https://tracker.my.com/contact)

## 📄 License

MyTracker PHP API Client is an open-sourced software licensed under the [MIT license](LICENSE.md).
