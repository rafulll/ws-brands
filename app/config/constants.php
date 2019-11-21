<?php
namespace Config\Constants;
// Bandeiras de cartão de crédito
define("BRANDS", serialize(
    array(
        "mister" => array(
            "cod_bandeira" => ["1111"],
            "bandeira" => "mister",
            "limite_parcelas" => 12,
            "operadores_permitidos" => array(
                "op-01" => true,
                "op-02" => true,
                "op-03" => true
            )
        ),
        "vista" => array(
            "cod_bandeira" => ["2222"],
            "bandeira" => "vista",
            "limite_parcelas" => 6,
            "operadores_permitidos" => array(
                "op-02" => true
            )
        ),
        "daciolo" => array(
            "cod_bandeira" =>  ["3333"],
            "bandeira" => "daciolo",
            "limite_parcelas" => 4,
            "operadores_permitidos" => array(
                "op-03" => true
            )
        )
    ) 
));