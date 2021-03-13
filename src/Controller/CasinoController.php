<?php

namespace App\Controller;

use Google_Client;
use Google_Service_Sheets;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CasinoController extends AbstractController
{
    const CACHE_SECONDS_DURATION = 10;

    private function cmp($a, $b) {
        if (count($a) < 4 || count($b) < 4) {
            return -1;
        }
        if ($a[2] == $b[2]) {
            return 0;
        }
        return ($a[2] < $b[2]) ? -1 : 1;
    }

    private function getSheet($client) {
        $service = new Google_Service_Sheets($client);

        // https://docs.google.com/spreadsheets/d/1nY_G4i-JpBZQlJ9A4ihybNerAbEWFNYpl4LmQvx5wOA/edit?usp=sharing
        $spreadsheetId = '1nY_G4i-JpBZQlJ9A4ihybNerAbEWFNYpl4LmQvx5wOA';
        $range = 'Sheet1!A3:E';

        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
        return $values;
    }

    /**
     * @Route("/casino", name="casino")
     */
    public function index(CacheInterface $pool, Google_Client $client): Response
    {
        // The callable will only be executed on a cache miss.
        $sheets = $pool->get('google_sheets', function (ItemInterface $item) use ($client) {
            $item->expiresAfter($this::CACHE_SECONDS_DURATION);
            $computedValue = $this->getSheet($client);
            if ($computedValue == null) {
                return array();
            }
            usort($computedValue, [$this, 'cmp']);
            return $computedValue;
        });

        return $this->render('casino.html.twig', [
            'sheets' => $sheets,
        ]);
    }
}
