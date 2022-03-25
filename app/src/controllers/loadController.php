<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\GetNames;
use src\class\LoadRide;
use src\core\View;
use src\core\Controller;
use Laminas\Diactoros\Response;
use stdClass;

class loadController extends Controller
{

    use GetNames;

    private $ride, $request;

    public View $view; // Responsavel por renderizar a view home

    public function __construct()
    {
        $this->view = new View(__DIR__, get_class($this));
    }

    // Renderiza a view de dashboard
    public function load(): Response
    {
        // Dados para renderização no template
        $this->view->addData($this->dataTheme('Carregar Dados'), 'theme');

        $data = $this->datasets();
        $data += ['url' => url('saveData')];
        $this->view->addData($data, 'dataTable');

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }

    public function saveData(): Response
    {
        $this->request = getRequest()->getParsedBody();
        dump($this->request);
        exit;

        $response = ['status' => true, 'message' => "Dado salvo"];
        return $this->responseJson($response);
    }

    private function datasets(): array
    {

        $riders = [];

        $rider = new stdClass();
        $rider->name = '1';
        $rider->dataset = CONF_RIDER1_DATASET1;
        $rider->atividade = count($this->getFileNames(CONF_RIDER1_DATASET1));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '2';
        $rider->dataset = CONF_RIDER2_DATASET1;
        $rider->atividade = count($this->getFileNames(CONF_RIDER2_DATASET1));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '3';
        $rider->dataset = CONF_RIDER3_DATASET1;
        $rider->atividade = count($this->getFileNames(CONF_RIDER3_DATASET1));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '4';
        $rider->dataset = CONF_RIDER4_DATASET1;
        $rider->atividade = count($this->getFileNames(CONF_RIDER4_DATASET1));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '5';
        $rider->dataset = CONF_RIDER5_DATASET1;
        $rider->atividade = count($this->getFileNames(CONF_RIDER5_DATASET1));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '6';
        $rider->dataset = CONF_RIDER6_DATASET1;
        $rider->atividade = count($this->getFileNames(CONF_RIDER6_DATASET1));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '7';
        $rider->dataset = CONF_RIDER7_DATASET1;
        $rider->atividade = count($this->getFileNames(CONF_RIDER7_DATASET1));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '8';
        $rider->dataset = CONF_RIDER8_DATASET1;
        $rider->atividade = count($this->getFileNames(CONF_RIDER8_DATASET1));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '9';
        $rider->dataset = CONF_RIDER9_DATASET1;
        $rider->atividade = count($this->getFileNames(CONF_RIDER9_DATASET1));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '10';
        $rider->dataset = CONF_RIDER1_DATASET2;
        $rider->atividade = count($this->getFileNames(CONF_RIDER1_DATASET2));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '11';
        $rider->dataset = CONF_RIDER2_DATASET2;
        $rider->atividade = count($this->getFileNames(CONF_RIDER2_DATASET2));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '12';
        $rider->dataset = CONF_RIDER3_DATASET2;
        $rider->atividade = count($this->getFileNames(CONF_RIDER3_DATASET2));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '13';
        $rider->dataset = CONF_RIDER4_DATASET2;
        $rider->atividade = count($this->getFileNames(CONF_RIDER4_DATASET2));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '14';
        $rider->dataset = CONF_RIDER5_DATASET2;
        $rider->atividade = count($this->getFileNames(CONF_RIDER5_DATASET2));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '15';
        $rider->dataset = CONF_RIDER6_DATASET2;
        $rider->atividade = count($this->getFileNames(CONF_RIDER6_DATASET2));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '16';
        $rider->dataset = CONF_RIDER7_DATASET2;
        $rider->atividade = count($this->getFileNames(CONF_RIDER7_DATASET2));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '17';
        $rider->dataset = CONF_RIDER1_DATASET3;
        $rider->atividade = count($this->getFileNames(CONF_RIDER1_DATASET3));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '18';
        $rider->dataset = CONF_RIDER3_DATASET3;
        $rider->atividade = count($this->getFileNames(CONF_RIDER3_DATASET3));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '19';
        $rider->dataset = CONF_RIDER6_DATASET3;
        $rider->atividade = count($this->getFileNames(CONF_RIDER6_DATASET3));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '20';
        $rider->dataset = CONF_RIDER7_DATASET3;
        $rider->atividade = count($this->getFileNames(CONF_RIDER7_DATASET3));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '21';
        $rider->dataset = CONF_RIDER8_DATASET3;
        $rider->atividade = count($this->getFileNames(CONF_RIDER8_DATASET3));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '22';
        $rider->dataset = CONF_RIDER9_DATASET3;
        $rider->atividade = count($this->getFileNames(CONF_RIDER9_DATASET3));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '23';
        $rider->dataset = CONF_RIDER10_DATASET3;
        $rider->atividade = count($this->getFileNames(CONF_RIDER10_DATASET3));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '24';
        $rider->dataset = CONF_RIDER12_DATASET3;
        $rider->atividade = count($this->getFileNames(CONF_RIDER12_DATASET3));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '25';
        $rider->dataset = CONF_RIDER13_DATASET3;
        $rider->atividade = count($this->getFileNames(CONF_RIDER13_DATASET3));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '26';
        $rider->dataset = CONF_RIDER14_DATASET3;
        $rider->atividade = count($this->getFileNames(CONF_RIDER14_DATASET3));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '27';
        $rider->dataset = CONF_RIDER1_DATASET4;
        $rider->atividade = count($this->getFileNames(CONF_RIDER1_DATASET4));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '28';
        $rider->dataset = CONF_RIDER3_DATASET4;
        $rider->atividade = count($this->getFileNames(CONF_RIDER3_DATASET4));
        array_push($riders, $rider);

        $rider = new stdClass();
        $rider->name = '29';
        $rider->dataset = CONF_RIDER4_DATASET4;
        $rider->atividade = count($this->getFileNames(CONF_RIDER4_DATASET4));
        array_push($riders, $rider);

        return ['riders' => $riders];
    }
}
