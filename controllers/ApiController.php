<?php

namespace app\controllers;

use Aws\Credentials\Credentials;
use Aws\Signature\SignatureV4;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;

class ApiController extends \yii\web\Controller
{
    public function actionIndex(){

        // https://stackoverflow.com/questions/45514989/how-to-access-api-from-aws-api-gateway-with-php-sdk-3

        $access_key = 'AKIAQPKIWTEF64I7QLEC';
        $secret_key = '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';

        $url = 'https://api.listarobinson.es/v1/api/user/998202202f5b7a2027d8acb1775419f';

        $credentials = new Credentials($access_key, $secret_key);

        $client = new Client();

        $request = new Request('GET', $url);

        $s4 = new SignatureV4('execute-api', 'eu-west-1');

        $signedrequest  = $s4->signRequest($request, $credentials);

        try{
            $response = $client->send($signedrequest);

            $data = $response->getBody();
        }catch (ClientException $exc){
            $data = $exc->getResponse()->getBody()->getContents();

        }

        echo '<pre>';
        var_dump($data);
        exit();
    }
}
