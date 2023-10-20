<?php

declare(strict_types=1);

class BitcoinPrice
{
    private string $api = "https://api.coindesk.com/v1/bpi/currentprice.json";

    public function __construct()
    {}

    public function fetchPriceData(): ?array
    {
        try {
            $response = file_get_contents($this->api);
            if ($response === false) {
                throw new Exception("Failed to fetch data from api");
            }

            $data = json_decode($response, true);
            return $data;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    public function displayPrices(): void
    {
        $data = $this->fetchPriceData();
        if ($data) {
            $bpi = $data['bpi'];
            if ($bpi) {
                echo "Current Bitcoin Price per 1 Bitcoin: " . PHP_EOL;
                foreach ($bpi as $currency => $info) {
                    echo "$currency: {$info['rate']} {$info['description']}" . PHP_EOL;
                }
            } else {
                echo "No price found" . PHP_EOL;
            }
        } else {
            echo "Unable to fetch data";
        }
    }
}

$bitcoinPrice = new BitcoinPrice();
$bitcoinPrice->displayPrices();