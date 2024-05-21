<?php

declare(strict_types=1);

namespace App\Controller;

use App\CustomResponse as Response;
use Pimple\Psr11\Container;
use GuzzleHttp\Middleware;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Psr\Http\Message\ServerRequestInterface as Request;

 class Train
{
    private const API_NAME = 'indian-railway-unofficial-api';

    private const API_VERSION = '1.0.0';

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
       $this->client = new Client([
            'base_uri' => 'https://www.irctc.co.in/', 
            'timeout'  => 10
            // 'cookies'=>true,    
            // 'debug'=>true
        ,'headers'=>[
            'Content-Type'=>'application/json;charset=UTF-8',
            'Referer'=>'https://www.irctc.co.in/nget/train-search',
            'Origin'=>'https://www.irctc.co.in',
            'Greq'=>time(),
        ]]);;
        $initReq = $this->client->get('/')->getHeader('Set-Cookie')[0];
        $this->cookie = CookieJar::fromArray([
          'TS018d84e5'=>  substr(explode(';',$initReq)[0],13)
        ],'www.irctc.co.in');
    }

    public function Index(Request $request, Response $response): Response
    {
        $message = [
            'api' => self::API_NAME,
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];

        return $response->withJson($message);
    }

    public function GetStationList(Request $request, Response $response): Response
    {
        $stationList = $this->client->get('/eticketing/protected/mapps1/stationData',['headers'=>[
            'Content-Type'=>'application/x-www-form-urlencoded',
            'Referer'=>'https://www.irctc.co.in/nget/train-search',
            'Greq'=>time()
        ]]);
        $stationResp = $stationList;
        $message = [
       "message"=> $stationResp->getStatusCode()
        ];

        return $response->withJson(json_decode($stationResp->getBody()->getContents()));
       
    }

    public function TrainSchedule(Request $request, Response $response, array $args): Response
    {
            $resp = $this->client->get('/eticketing/protected/mapps1/trnscheduleenquiry/'.$args['id'],[
                'headers'=>[
                    'Content-Type'=>'application/x-www-form-urlencoded',
                    'Referer'=>'https://www.irctc.co.in/nget/train-search',
                    'Greq'=>time()
                ]
                ]);

        return $response->withJson(json_decode($resp->getBody()->getContents(),true,JSON_PRETTY_PRINT));
    }

    public function TrainFare(Request $request, Response $response, array $args): Response
    {
        $params = (array)$request->getParsedBody();
        $srcStation = $params['src'];
        $destStation =  $params['dest'];
        $trainNo = $params['train_no'];
        $quota = $params['quota'];
        $classCode = $params['class_code'];
            
            return $response->withJson($args['id']);
    }
    public function TrainsBetweenStations(Request $request, Response $response, array $args): Response
    {
        
        $params = (array)$request->getParsedBody();
        $srcStation = $params['src'];
        $destStation =  $params['dest'];
        $date = $params['date'];

        $paramArray = array();
        $paramArray['concessionBooking']=false;
        $paramArray['currentBooking']=false;
        $paramArray['destStn']=$destStation;
        $paramArray['srcStn']=$srcStation;
        $paramArray['flexiFlag']=false;
        $paramArray['fltBooking']=false;
        $paramArray['handicapFlag']=false;
        $paramArray['jrnyClass']="";
        $paramArray['jrnyDate']=$date;
        $paramArray['loyaltyRedemptionBooking']=false;
        $paramArray['quotaCode']='GN';
        $paramArray['ticketType']='E';

        $config = json_encode($paramArray);
        // var_dump($config);
        $resp = $this->client->post('/eticketing/protected/mapps1/altAvlEnq/TC',['body'=>$config,'cookies'=>$this->cookie]);
        return $response->withJson($resp->getBody()->getContents( ));
    }

    public function TrainComposition(Request $request, Response $response, array $args): Response
    {
        $params = (array)$request->getParsedBody();
        $jDate = $params['jrnyDate'];
        $brdStn =  $params['boardingStation'];
        $trainNo = $params['train_no'];

        $data = array();
        $data['boardingStation']=$brdStn;
        $data['jDate']=$jDate;
        $data['trainNo']=$trainNo;
        
        $data = json_encode($data);

        $req  = $this->client->post('/online-charts/api/trainComposition',[
            'headers'=>
        [
            'Content-Type'=>'application/json;charset=UTF-8',
            'Referer'=>'    https://www.irctc.co.in/online-charts',
            'Origin'=>'https://www.irctc.co.in',
        ],'body'=>$data,'cookies'=>$this->cookie]);

        return $response->withJson(json_decode($req->getBody()->getContents()));
    }

}
