<?php


class Controller
{
    public function gerarTabelaPrice()
    {
        if (!empty($_POST)) {

            $pv = filter_input(INPUT_POST, 'pv', FILTER_DEFAULT);
            $i = filter_input(INPUT_POST, 'i', FILTER_DEFAULT);
            $n = filter_input(INPUT_POST, 'n', FILTER_SANITIZE_NUMBER_INT);
            $p = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_NUMBER_INT);

            $price = new TabelaPrice();

            $price->pv = !empty($pv) ? moedaMySQL($pv) : '';
            $price->p = !empty($p) ? moedaMySQL($p) : '';
            $price->i = !empty($i) ? moedaMySQL($i) : '';
            $price->n = $n;

            //var_dump($price->pv, $price->i, $price->n);

            $dados = $price->calcular();

            $dados['dataform'] = [
                'pv' => $pv,
                'i' => $i,
                'n' => $n,
                'p' => $p,
            ];
        }

        render('parcelas.price', ['dados' => $dados]);
    }
}
