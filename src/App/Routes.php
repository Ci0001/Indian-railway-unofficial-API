<?php

declare(strict_types=1);
use Slim\Routing\RouteCollectorProxy;

$app->get('/', 'App\Controller\Train:Index');
$app->group("/v1"  ,function(RouteCollectorProxy $group) {
    $group->get('/stations','App\Controller\Train:GetStationList');
    $group->get('/trains/{id}/schedule','App\Controller\Train:TrainSchedule');
    $group->post('/trains/{id}/fare','App\Controller\Train:TrainFare');
    $group->post('/trains','App\Controller\Train:TrainsBetweenStations');
    //RESERVATION CHARTS
        //TRAIN COMPOSITION
        $group->post('/trains/reservation-chart/train-composition','App\Controller\Train:TrainComposition');
        //COACH COMPOSITION
        $group->post('/trains/reservation-chart/coach-composition','App\Controller\Train:CoachComposition');
});