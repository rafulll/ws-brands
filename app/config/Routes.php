<?php

namespace Config;

use Slim\App;
use Controllers\V1\BrandController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class Routes {

    private $app;

    public function __construct(App $app) {
        $this->app = $app;

        if (!empty($this->app)) {
            $this->initRoutesV1();
        } else {
            throw new Exception("Slim não iniciado.");
        }
    }

    private function initRoutesV1() {
        $app = $this->app;

        $app->group("/v1", function() use ($app) {

            /* Métodos GET */
            $app->get("/status", array(BrandController::class, "getStatus"));
            $app->post("/pay", array(BrandController::class, "payC"));

            $app->get("/installment-limits/{brand}", array(BrandController::class, "getOperator"));
            $app->get("/installment-limits/{brand}/{parcelas}", array(BrandController::class, "getOperator"));
            $app->get("/cartao/{brand}/{parcelas}", array(BrandController::class, "getOperator"));
            $app->post("/cartao/{brand}/{parcelas}", array(BrandController::class, "getOperator"));


            /* Métodos POST */
            
        });
    }
}