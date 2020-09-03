<?php

/**
 * Fazer a montagem da tabela price
 */
class TabelaPrice
{
    // Valor presente
    public $pv;

    // Taxa de juros
    public $i;

    // Número de parcelas
    public $n;

    // Valor parcela
    public $p;

    // Saldo devedor
    public $sd;

    private $prestacao;
    private $valor_presente;
    private $juros;
    private $amortizacao;
    private $saldo_devedor;

    public function taxaJurosUnitaria($i)
    {
        if (!$i) {
            throw new \Exception("Valor da taxa não informado", 1);
        }

        return ($i / 100);
    }

    public function calcularParcela()
    {
        $i = $this->taxaJurosUnitaria($this->i);

        $n = $this->n;
        if (!$n) {
            throw new \Exception("Numero de parcelas não informado", 1);
        }

        $pv = $this->pv;
        if (!$pv) {
            throw new \Exception("Valor presente não informado", 1);
        }

        $numerador = pow((1 + $i), $n) * $i;

        $denominador = pow((1 + $i), $n) - 1;

        $this->prestacao = $pv * ($numerador / $denominador);

        return $this->prestacao;
    }


    public function calcularValorPresente()
    {
        $i = $this->taxaJurosUnitaria($this->i);

        if (!$i) {
            throw new \Exception("Valor da taxa não informado", 1);
        }

        $p = $this->p;
        if (!$p) {
            throw new \Exception("Valor da parcela não informado", 1);
        }

        $n = $this->n;
        if (!$n) {
            throw new \Exception("Numero de parcelas não informado", 1);
        }

        $numerador = pow((1 + $i), $n) * $i;

        $denominador = pow((1 + $i), $n) - 1;

        $this->pv = ($p / ($numerador / $denominador)) / 100;

        return $this->pv;
    }

    public function calcularJuros()
    {
        if (empty($this->saldo_devedor)) {
            $this->saldo_devedor = $this->pv;
        }

        $i = $this->taxaJurosUnitaria($this->i);

        $this->juros = ($this->saldo_devedor * $i);

        return $this->juros;
    }

    public function calcularAmortizacao()
    {
        $this->amortizacao = ($this->prestacao - $this->juros);
        return $this->amortizacao;
    }

    public function calcularSaldoDevedor()
    {
        $sd = ($this->saldo_devedor - $this->amortizacao);

        $this->saldo_devedor = ($sd > 0) ? $sd : 0;
        return $this->saldo_devedor;
    }

    public function dadosTabela()
    {
        for ($i = 1; $i <= $this->n; $i++) {

            $juros = $this->calcularJuros();

            $amortizacao = $this->calcularAmortizacao();

            $saldo_devedor = $this->calcularSaldoDevedor();

            $parcelas[$i] = [
                'mes' => $i,
                'prestacao' => $this->prestacao,
                'juros' => $juros,
                'amortizacao' => $amortizacao,
                'saldo_devedor' => $saldo_devedor,
            ];
        }

        return $parcelas;
    }

    public function calcular()
    {
        // Informou a parcela para calcular o valor presente
        if (empty($this->pv) && !empty($this->p)) {
            $valor_presente = $this->calcularValorPresente();
        }

        $this->calcularParcela();

        return [
            'valor_presente' => $this->pv,
            'numero_parcelas' => $this->n,
            'taxa' => $this->i,
            'pretacao' => $this->prestacao,
            'prestacoes' => $this->dadosTabela(),
        ];
    }
}
