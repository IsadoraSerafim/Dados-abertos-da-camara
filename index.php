<?php

// Primeiro busca todos os deputados
$url = "https://dadosabertos.camara.leg.br/api/v2/deputados?itens=513";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

$dados = json_decode($response, true);

// Função para buscar os gastos do deputado
function buscarGastos($idDeputado) {
    $urlGastos = "https://dadosabertos.camara.leg.br/api/v2/deputados/$idDeputado/despesas?itens=1&ordem=DESC&ordenarPor=ano";
    
    $ch = curl_init($urlGastos);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json"
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $dados = json_decode($response, true);
    
    if (isset($dados['dados'][0]['valorDocumento'])) {
        return $dados['dados'][0]['valorDocumento'];
    } else {
        return 0;
    }
}

// Função para buscar as votações (sem filtrar por ano)
function buscarVotacoes($idDeputado) {
    $urlVotacao = "https://dadosabertos.camara.leg.br/api/v2/deputados/$idDeputado/votacoes?itens=50&ordem=DESC&ordenarPor=dataHoraRegistro";

    $ch = curl_init($urlVotacao);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Accept: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $dados = json_decode($response, true);

    if (isset($dados['dados']) && count($dados['dados']) > 0) {
        $votacoes = [];
        foreach ($dados['dados'] as $votacao) {
            $votacoes[] = [
                'descricao' => $votacao['descricao'],
                'tipoVoto' => $votacao['tipoVoto'],
                'dataHora' => $votacao['dataHoraRegistro']
            ];
        }
        return $votacoes;
    } else {
        return null;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Deputados - Dados Abertos da Câmara</title>
</head>
<body>
    <h1>Deputados Federais - API Dados Abertos da Câmara</h1>
    <?php if (isset($dados['dados'])): ?>
        <?php foreach ($dados['dados'] as $dep): ?>
            <?php 
                $gasto = buscarGastos($dep['id']);
                $votacoes = buscarVotacoes($dep['id']);
            ?>
            <div class="deputado" style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                <img src="<?= $dep['urlFoto'] ?>" alt="Foto de <?= $dep['nome'] ?>" width="80">
                <div>
                    <strong>Nome:</strong> <?= $dep['nome'] ?><br>
                    <strong>Partido:</strong> <?= $dep['siglaPartido'] ?><br>
                    <strong>UF:</strong> <?= $dep['siglaUf'] ?><br>
                    <strong>Último gasto declarado:</strong> R$ <?= number_format($gasto, 2, ',', '.') ?><br>
                    
                    <?php if ($votacoes): ?>
                        <strong>Votações:</strong><br>
                        <ul>
                            <?php foreach ($votacoes as $votacao): ?>
                                <li>
                                    <strong>Data:</strong> <?= date("d/m/Y H:i", strtotime($votacao['dataHora'])) ?><br>
                                    <strong>Descrição:</strong> <?= $votacao['descricao'] ?><br>
                                    <strong>Tipo de voto:</strong> <?= $votacao['tipoVoto'] ?><br><br>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <strong>Sem votações registradas.</strong>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Erro ao carregar dados da API.</p>
    <?php endif; ?>
</body>
</html>
