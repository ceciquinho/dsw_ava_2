<?php
require __DIR__ . '/vendor/autoload.php';
 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
 
$app = AppFactory::create();
 
// Middleware para permitir JSON como retorno padrão
$app->addBodyParsingMiddleware();
 
// Rota: /uma-api
$app->get('/uma-api', function (Request $request, Response $response) {
    $data = [
        "titulo" => "O que é uma API?",
        "explicacao" => "API significa Interface de Programação de Aplicações. Ela permite que diferentes sistemas se comuniquem entre si, por meio de requisições e respostas, geralmente utilizando o protocolo HTTP. Em APIs REST, usamos os métodos GET, POST, PUT e DELETE para acessar ou modificar recursos disponíveis em um servidor. APIs são fundamentais para conectar serviços, como aplicativos móveis e sistemas web."
    ];
    $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
    return $response->withHeader('Content-Type', 'application/json');
});
 
// Rota: /codigos
$app->get('/codigos', function (Request $request, Response $response) {
    $codigos = [
        "200" => "OK - Requisição bem-sucedida.",
        "201" => "Created - Recurso criado com sucesso.",
        "204" => "No Content - Requisição bem-sucedida, sem conteúdo de retorno.",
        "400" => "Bad Request - Requisição malformada ou inválida.",
        "401" => "Unauthorized - Autenticação necessária.",
        "403" => "Forbidden - Acesso negado.",
        "404" => "Not Found - Recurso não encontrado.",
        "405" => "Method Not Allowed - Método HTTP não permitido.",
        "500" => "Internal Server Error - Erro interno no servidor.",
        "503" => "Service Unavailable - Serviço temporariamente indisponível."
    ];
    $response->getBody()->write(json_encode([
        "titulo" => "Códigos de Status HTTP",
        "descricao" => "Lista de alguns códigos HTTP mais comuns utilizados em APIs REST.",
        "codigos" => $codigos
    ], JSON_PRETTY_PRINT));
    return $response->withHeader('Content-Type', 'application/json');
});
 
// Rota: /erro
$app->get('/erro', function (Request $request, Response $response) {
    $erro = [
        "erro" => true,
        "mensagem" => "Não encontrado",
        "status" => 404
    ];
    $response->getBody()->write(json_encode($erro, JSON_PRETTY_PRINT));
    return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
});
 
// Rota padrão para tratar qualquer endpoint não encontrado
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
 
$app->run();