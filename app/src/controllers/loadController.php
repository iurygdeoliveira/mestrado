<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\Datasets;
use src\class\LoadRide;
use src\core\View;
use src\core\Controller;
use Laminas\Diactoros\Response;

class loadController extends Controller
{

    use Datasets;

    private $ride;

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

        // Dados para renderização do dataTable
        $data = $this->datasets();
        $data += ['url' => url('saveData')];
        $this->view->addData($data, 'dataTable');

        $response = new Response();
        $response->getBody()->write(
            $this->view->render(__FUNCTION__, [])
        );

        return $response;
    }

    //   "rider" => "6"
    //   "dataset" => "/var/www/html/app/src/support/../datasets/dataset1/Rider6/"
    //   "count" => "63"
    //   "atividade" => "60"
    public function saveData(): Response
    {

        set_time_limit(60);
        $request = getRequest()->getParsedBody();
        $this->ride = new LoadRide($request['dataset'], $request['rider']);
        $result = $this->ride->loadRide($request['dataset'] . $request['atividade']);

        // Arquivo não encontrado
        if ($result->fail()) {
            $response = ['status' => false, 'message' => $result->message()];
            return $this->responseJson($response);
        }

        // Problema ao salvar no BD
        if ($result->save() == false) {
            $response = ['status' => false, 'message' => $result->message()];
            return $this->responseJson($response);
        }

        $response = ['status' => true, 'message' => "Cadastro realizado com sucesso"];
        return $this->responseJson($response);
    }
}
