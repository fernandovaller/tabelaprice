<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabela Price</title>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f9f9f9;
        }

        .table {
            background-color: #fff;
        }

        .p-0 {
            padding: 0;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mr-3 {
            margin-right: 20px;
        }

        .moeda {
            text-align: right;
        }

        .table-borderless tbody>tr>td {
            border: none;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="//oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body>

    <div class="container">

        <h1>Tabela Price</h1>
        <p>Simular financiamento utilizando a Tabela Price</p>

        <hr>

        <div class="panel panel-default hidden-print">
            <div class="panel-heading">
                Informe os dados para simular
            </div>
            <div class="panel-body">

                <form action="?method=gerarTabelaPrice" method="POST">

                    <div class="row">

                        <div class="form-group col-sm-3">
                            <label for="">Sado devedor</label>
                            <div class="input-group">
                                <span class="input-group-addon">PV</span>
                                <input type="text" name="pv" class="form-control moeda" value="<?= $dados['dataform']['pv'] ?>" placeholder="">
                            </div>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="">Nº de parcelas</label>
                            <div class="input-group">
                                <span class="input-group-addon">n</span>
                                <input type="number" name="n" class="form-control" value="<?= $dados['dataform']['n'] ?>" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="">Taxa de juros (%)</label>
                            <div class="input-group">
                                <span class="input-group-addon">i</span>
                                <input type="text" name="i" class="form-control moeda" value="<?= $dados['dataform']['i'] ?>" placeholder="" required>
                            </div>
                        </div>

                        <div class="form-group col-sm-3">
                            <label for="">Parcela</label>
                            <div class="input-group">
                                <span class="input-group-addon">P</span>
                                <input type="text" name="p" class="form-control moeda" value="<?= $dados['dataform']['p'] ?>" placeholder="">
                            </div>
                        </div>

                    </div><!-- row -->

                    <a href="/" class="btn btn-default mr-3"><i class="fa fa-close fa-fw"></i> Limpar</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Calcular</button>

                </form>

            </div><!-- panel-body -->
        </div> <!-- panel -->

        <div class="panel panel-default">
            <div class="panel-heading">
                Dados informado
            </div>
            <div class="panel-body">

                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr class="h4">
                            <td width="150" class="text-muted">Valor presente</td>
                            <td>R$ <?= moeda($dados['valor_presente']) ?></td>

                            <td width="150" class="text-muted">Nº de parcelas</td>
                            <td><?= $dados['numero_parcelas'] ?></td>

                            <td width="150" class="text-muted">Taxa de juros</td>
                            <td><?= moeda($dados['taxa']) ?>%</td>

                            <td width="150" class="text-muted">Valor prestação</td>
                            <td>R$ <?= moeda($dados['pretacao']) ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Parcelas na tabela price
            </div>
            <div class="panel-body p-0">

                <table class="table table-condensed table-hover mb-0">
                    <thead>
                        <tr class="active">
                            <th width="10">Mês</th>
                            <th class="text-right">PARCELA</th>
                            <th class="text-right">JUROS</th>
                            <th class="text-right">AMORTIZAÇÃO</th>
                            <th class="text-right">SALDO DEVEDOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($dados) : ?>

                            <?php
                            $total_prestacao = 0;
                            $total_juros = 0;
                            $total_amortizacao = 0;

                            foreach ($dados['prestacoes'] as $key => $row) :
                                $total_prestacao += $row['prestacao'];
                                $total_juros += $row['juros'];
                                $total_amortizacao += $row['amortizacao'];

                            ?>
                                <tr>
                                    <td class="text-center"><?= $row['mes'] ?></td>
                                    <td class="text-right"><?= moeda($row['prestacao']) ?></td>
                                    <td class="text-right"><?= moeda($row['juros']) ?></td>
                                    <td class="text-right"><?= moeda($row['amortizacao']) ?></td>
                                    <td class="text-right"><?= moeda($row['saldo_devedor']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                    <tfoot>
                        <tr class="active">
                            <th>&nbsp;</th>
                            <th class="text-right"><?= moeda($total_prestacao) ?></th>
                            <th class="text-right"><?= moeda($total_juros) ?></th>
                            <th class="text-right"><?= moeda($total_amortizacao) ?></th>
                            <th class="text-right">&nbsp;</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- panel-body -->
        </div> <!-- panel -->

    </div> <!-- container -->


    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.moeda').mask('000.000.000.000.000,00', {
                reverse: true
            });
        });
    </script>
</body>

</html>
