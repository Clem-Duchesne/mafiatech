<?php

namespace App\Controller;

use Google_Client;
use Google_Service_Sheets;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class RankingController extends AbstractController
{
    const CACHE_SECONDS_DURATION = 5;

    private function getSheet($client) {
        $service = new Google_Service_Sheets($client);

        // FIXME
        // https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        $spreadsheetId = '1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms';
        $range = 'Class Data!A2:E';
        // FIXME

        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
        return $values;
    }

    /**
     * @Route("/classement", name="ranking")
     */
    public function index(CacheInterface $pool, Google_Client $client): Response
    {
        // The callable will only be executed on a cache miss.
        $sheets = $pool->get('google_sheets', function (ItemInterface $item) use ($client) {
            $item->expiresAfter($this::CACHE_SECONDS_DURATION);
            $computedValue = $this->getSheet($client);
            return $computedValue;
        });

        return $this->render('ranking/index.html.twig', [
            'sheets' => $sheets,
        ]);
    }
}
