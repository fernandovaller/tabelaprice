<?php

// Formar valores para padrão brasileiro
function moeda($value, $decimals  = 2)
{

    if (empty($value)) {
        return '0';
    }

    // Remove a virgula do valor
    $value = str_replace(',', '', $value);

    // Formata usando o numero de casas decimais desejado
    return number_format($value, $decimals, ',', '.');
}

// Formar valores para salvar no MySQL
function moedaMySQL($value, $decimals = 2)
{
    if (empty($value)) {
        return '0';
    }

    // Remove o ponto
    $value = str_replace('.', '', $value);
    // Troca o a virgula pelo ponto
    $value = str_replace(',', '.', $value);

    // Formata usando o numero de casas decimais desejado
    return number_format($value, $decimals, '.', '');
}

// Renderizar view
function render($content, $data)
{
    extract($data);
    require PATH_VIES . "/{$content}.php";
    exit();
}
