<?php

namespace Config;

use Slim\App;
use Controllers\V1\BrandController;


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
        $container = $app->getContainer();

        // Register component on container
        $container['view'] = function ($container) {
            $view = new \Slim\Views\Twig('.\views',[
                'cache' => false
            ]);
        
            // Instantiate and add Slim specific extension
            $router = $container->get('router');
            $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
            $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
        
            return $view;
        };
        $app->group("/v1", function() use ($app) {

            /* Métodos GET */
            $app->get(
                "/status",
                array(BrandController::class, "getStatus")
            );
            $app->post(
                "/pay",
                array(BrandController::class, "payC")
            );



            /* Métodos POST */
            
        });
    }
}