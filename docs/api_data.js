define({ "api": [
  {
    "type": "GET",
    "url": "/ws-brands/v1/status",
    "title": "Brands - Status da API",
    "version": "0.0.1",
    "description": "<p>Verifica a disponibilidade da API</p>",
    "group": "Recursos_Abertos",
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "status",
            "description": "<p>Resultado da disponibilidade do servidor.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "[JSON] Success-Response",
          "content": "{\n  'status': 'Serviço disponível WS2'\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/controllers/v1/BrandController.php",
    "groupTitle": "Recursos_Abertos",
    "name": "GetWsBrandsV1Status"
  },
  {
    "type": "GET",
    "url": "/ws-brands/v1/installments-limit/:bandeira",
    "title": "Brands - Limite de parcelas",
    "version": "0.0.1",
    "description": "<p>Verifica a quantidade permitida de parcelas em uma compra a partir da bandeira informada.</p>",
    "group": "Recursos_Autenticados",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "brand",
            "description": "<p>Nome da bandeira segundo opções a seguir: mister (12 parcelas), vista (6 parcelas) e daciolo (4 parcelas)</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "bandeira",
            "description": "<p>Bandeira requisitada.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "limite_parcelas",
            "description": "<p>Limite de parcelas que a bandeira aceita.</p>"
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "operadores_permitidos",
            "description": "<p>Conjunto de operadores que tem relação com a bandeira.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "[JSON] Resposta-Sucesso",
          "content": "{\n  \"bandeira\": \"mister\",\n  \"limite_parcelas\": 12,\n  \"operadores_permitidos\": {\n    \"op-01\": true,\n    \"op-02\": true,\n    \"op-03\": true\n  }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "400": [
          {
            "group": "400",
            "type": "String",
            "optional": false,
            "field": "resposta",
            "description": "<p>Resposta resultado.</p>"
          },
          {
            "group": "400",
            "type": "String",
            "optional": false,
            "field": "detalhes",
            "description": "<p>Detalhes do erro</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "[JSON] Resposta-Erro",
          "content": "{\n  \"resposta\": \"erro\",\n  \"detalhes\": \"A bandeira informada não existe\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/controllers/v1/BrandController.php",
    "groupTitle": "Recursos_Autenticados",
    "name": "GetWsBrandsV1InstallmentsLimitBandeira"
  },
  {
    "type": "POST",
    "url": "/ws-brands/v1/pay/:bandeira",
    "title": "Brands - Recebe dados para pagamento",
    "version": "0.0.1",
    "description": "<p>Envia para a bandeira do cartão a solicitação de pagamento.</p>",
    "group": "Recursos_Autenticados",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "numero_cartao",
            "description": "<p>Número do cartão de crédito. O segundo conjunto de números</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "nome_cliente",
            "description": "<p>Nome do titular do cartão de crédito.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bandeira",
            "description": "<p>Nome da bandeira segundo opções a seguir: mister (cod.: 1111), vista (cod.: 2222) ou daciolo (cod.: 3333).</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "cod_seguranca",
            "description": "<p>Código de três dígitos.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "valor_em_centavos",
            "description": "<p>Valor em centavos da compra.</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "parcelas",
            "description": "<p>Quantidade de parcelas para o pagamento.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "cod_operadora",
            "description": "<p>Código único da operadora de cartão. Será usado para que a bandeira verifique se o operador é seu cliente.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "[JSON] Exemplo Corpo da Requisição",
          "content": "{\n  \"numero_cartao\": \"1111.2222.3333.4444\",\n  \"nome_cliente\": \"USUARIO DA SILVA\",\n  \"bandeira\": \"mister\",\n  \"cod_seguranca\": 111,\n  \"valor_em_centavos\": 500,\n  \"parcelas\": 12,\n  \"cod_operadora\": \"op-xx\"\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "resposta",
            "description": "<p>Resultado da transação.</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "nome_cliente",
            "description": "<p>Nome do titular do cartão de crédito.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "valor_em_centavos",
            "description": "<p>Valor em centavos da compra.</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "parcelas",
            "description": "<p>Quantidade de parcelas em que o pagamento foi feito.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "[JSON] Exemplo-Resposta-Sucesso",
          "content": "{\n  \"resposta\": \"sucesso\",\n  \"nome_cliente\": \"USUARIO DE SOUSA\",\n  \"valor_em_centavos\": 500,\n  \"parcelas\": 12\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "400": [
          {
            "group": "400",
            "type": "String",
            "optional": false,
            "field": "cod_resposta",
            "description": "<p>Código de resposta da transação. operadora-negada para a operadora não autorizada a trabalhar com a bandeira.</p>"
          },
          {
            "group": "400",
            "type": "String",
            "optional": false,
            "field": "resposta",
            "description": "<p>Resultado da transação.</p>"
          },
          {
            "group": "400",
            "type": "String",
            "optional": false,
            "field": "detalhes",
            "description": "<p>Detalhes do erro</p>"
          },
          {
            "group": "400",
            "type": "String",
            "optional": false,
            "field": "cod_operadora",
            "description": "<p>Código da operadora de cartão.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "[JSON] Resposta-Erro-Operadora-Negada",
          "content": "{\n  \"cod_resposta\": \"operadora-negada\",\n  \"resposta\": \"falha\",\n  \"detalhes\": \"Operadora sem relação com a bandeira\",\n  \"cod_operadora\": \"op-xx\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/controllers/v1/BrandController.php",
    "groupTitle": "Recursos_Autenticados",
    "name": "PostWsBrandsV1PayBandeira"
  }
] });
