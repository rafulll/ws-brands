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
      //var_dump($dados);
        // $new_rq = json_encode($dados);
        // var_dump($new_rq);
        $vdata = [
            unserialize(BRANDS)
        ];
        $data[0] = $req->getParsedBody();
       // var_dump($data[0]['nome_cliente']);
        $str = str_replace(' ', '_', $data[0]['nome_cliente']);
        $data[0]['nome_cliente'] = $str;
       // var_dump($vdata[0][$data[0]['bandeira']]['limite_parcelas']);
        $cartao = explode(".",$data[0]['numero_cartao'],4);
        // echo "cpd cartap";
        
        // echo "bandeiras permitidas";
        // var_dump($vdata[0][$data[0]['bandeira']]['cod_bandeira']);
        $a = null;
        $cod = null;
         
        
        $arrayband = $vdata[0][$data[0]['bandeira']]['cod_bandeira'];
        //var_dump($arrayband);
        $i=0;
        //para cada bandeira
       foreach ($arrayband as $value ){
            $i++;
            //var_dump($vdata[0][$data[0]['bandeira']]['limite_parcelas']);
            //var_dump($value[$i]);
           //se a bandeira nao existir no operador
            if($cartao[3] != $value){
                $a = false;
                $resultado = [
                    "resultado" => "falha",
                    "detalhes" => "Problema com Codigo da Bandeira",
                    "bandeira" => $data[0]['bandeira'],
                    "parcelas_solicitadas" =>  $dados['parcelas'],
                    "limite_parcelas" => $vdata[0][$dados['bandeira']]['limite_parcelas']
                ];
                //var_dump($value);
                //var_dump($cartao[3]);
                return $res->withStatus(401)->withJson($resultado);

            }else{
               // var_dump($cartao[3]);
                // var_dump($value);
                
              
               
                //var_dump($value);
                $a = true;
                $cod = $value;
                //var_dump($cod);
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
                 
        
        //return $res->withStatus(200)->withJson($dados); 
        $ch = curl_init();
        
        $url="http://localhost/ws-banks/v1/pay";
       
      
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dados));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result=curl_exec($ch);
        //array_push($result,["limite_parcelas"=> $vdata[0][$dados['bandeira']]['limite_parcelas']]);
        //var_dump($result);
        $c = json_decode($result);
       //var_dump($c);
      // echo "chegou aqui";
       
       $json_errors = array(
        JSON_ERROR_NONE => 'No_errors',
        JSON_ERROR_DEPTH => 'Yes, The maximum stack depth has been exceeded',
        JSON_ERROR_CTRL_CHAR => 'Yes, Control character error, possibly incorrectly encoded',
        JSON_ERROR_SYNTAX => 'Yes,_Syntax error',
        );
        //echo 'Json_errors: __ ', $json_errors[json_last_error()], PHP_EOL, PHP_EOL;
        //var_dump($c);

        }
        //return $res->withStatus(200)->withJson($dados);

        $resultado = [
            //$rq->getParsedBody(),
            "resultado" => "OK",
            "detalhes" => "Sucessoo",
            "bandeira" => $dados['bandeira'],
            "parcelas_solicitadas" =>  $dados['parcelas'],
            "limite_parcelas" => $vdata[0][$dados['bandeira']]['limite_parcelas']


        ];   
        

        return $res->withStatus(200)->withJson($c);
       
    }
}