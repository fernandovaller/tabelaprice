<?php

require __DIR__ . '/bootstrap.php';

$method = filter_input(INPUT_GET, 'method', FILTER_SANITIZE_STRING);

$method_default = (empty($method)) ? 'gerarTabelaPrice' : $method;
$controller_default = "Controller";

$controller = new $controller_default();

call_user_func([$controller, $method_default], '');
