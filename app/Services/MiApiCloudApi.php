<?php

namespace App\Services;

use App\CoreFacturalo\Services\Helpers\Http\ContextClient;
use App\CoreFacturalo\Services\Models\Person;
use Exception;

class MiApiCloudApi
{
  private static $tokens = [
    'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxMDIsImV4cCI6MTc1MTQ5NjY3M30.akSErk2gLYsK4iCEMwch2OxEDVZ8HTazMGaBZd-7840'
    // Agregar más tokens aquí
  ];

  public static function search($number, $type)
  {
    $tokens = explode(",", env("TOKENS_MIAPICLOUD", ""));
    $ctokens = array_merge($tokens, self::$tokens);
    // dump($ctokens);
    while (!empty($ctokens)) {
      $claveAleatoria = array_rand($ctokens);
      $token = $ctokens[$claveAleatoria];

      $client = new \GuzzleHttp\Client([
        'headers' => [
          'Authorization' => 'Bearer ' . $token,
          'Accept'        => 'application/json',
        ],
      ]);
      try {
        $response = $client->get('https://miapi.cloud/v1/' . $type . '/' . $number);
        $data = json_decode($response->getBody(), true);







        if ($data['success']) {

          return [
            'success' => true,
            'data' => $data['datos']
          ];
        }
      } catch (Exception $ex) {
        //throw $th;
      }
      unset($ctokens[$claveAleatoria]);
    }
    return false;
  }
}
