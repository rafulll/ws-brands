<?php

namespace Controllers\V1;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


final class BrandController
{

    /**
     * @api {GET} /status Status da API
     * 
     * @apiVersion 1.0.0
     * 
     * @apiDescription Verifica a disponibilidade da API
     * 
     * @apiGroup Recursos Abertos
     * 
     * @apiSuccess (200) {String} status Resultado da disponibilidade do servidor.
     * 
     * @apiSuccessExample {JSON} Success-Response:
     *  {
     *      'status': 'Serviço disponível WS2'
     *  }
     */
    public static function getStatus(Request $req, Response $res, array $args)
    {
        $dados = [
            "status" => "Serviço disponível WS2"
        ];

        return $res->withStatus(200)->withJson($dados);
    }
    public static function payC(Request $req, Response $res, array $args)
    {
        $dados = $req->getParsedBody();

        $vdata = [
            unserialize(BRANDS)
        ];
        $data[0] = $req->getParsedBody();

        $str = str_replace(' ', '_', $data[0]['nome_cliente']);
        $data[0]['nome_cliente'] = $str;

        $cartao = explode(".",$data[0]['numero_cartao'],4);

        $a = null;
      
         
        
        $arrayband = $vdata[0][$data[0]['bandeira']]['cod_bandeira'];
      
       
       foreach ($arrayband as $value ){
            
         
            if($cartao[3] != $value){
                $a = false;
                $resultado = [
                    "resultado" => "falha",
                    "detalhes" => "Problema com Codigo da Bandeira",
                    "bandeira" => $data[0]['bandeira'],
                    "parcelas_solicitadas" =>  $dados['parcelas'],
                    "limite_parcelas" => $vdata[0][$dados['bandeira']]['limite_parcelas']
                ];
                
                return $res->withStatus(401)->withJson($resultado);

            }else{
               
                $a = true;
                
                $resultado = [
                    "resultado" => "OK",
                    "detalhes" => "Sucesso",
                    "bandeira" => $dados['bandeira'],
                    "parcelas_solicitadas" =>  $dados['parcelas'],
                    "limite_parcelas" => $vdata[0][$dados['bandeira']]['limite_parcelas']
                ];
               
                

            }
            
          
          

        }
        
        if($vdata[0][$dados['bandeira']]['limite_parcelas'] < $dados['parcelas']){
            $a = false;
            $resultado = [
                "resultado" => "Falha",
                "detalhes" => "Limite de parcelas nao conferem",
                "bandeira" => $data[0]['bandeira'],
                "parcelas_solicitadas" =>  $dados['parcelas'],
                "limite_parcelas" => $vdata[0][$dados['bandeira']]['limite_parcelas']
            ];  
            return $res->withStatus(401)->withJson($resultado);
        }if($a != true) {
            $resultado = [
                "resultado" => "Falha",
                "detalhes" => "Limite de parcelas nao conferem",
                "bandeira" => $data[0]['bandeira'],
                "parcelas_solicitadas" =>  $dados['parcelas'],
                "limite_parcelas" => $vdata[0][$dados['bandeira']]['limite_parcelas']
            ];  
            return $res->withStatus(401)->withJson($resultado);

        }
        else {
                 
        
        $ch = curl_init();
        
        $url="http://localhost/ws-banks/v1/pay";
       
      
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dados));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result=curl_exec($ch);
        $c = json_decode($result);
       
      

        }

        $resultado = [
            "resultado" => "OK",
            "detalhes" => "Sucessoo",
            "bandeira" => $dados['bandeira'],
            "parcelas_solicitadas" =>  $dados['parcelas'],
            "limite_parcelas" => $vdata[0][$dados['bandeira']]['limite_parcelas']


        ];   
        

        return $res->withStatus(200)->withJson($c);
       
    }
}
