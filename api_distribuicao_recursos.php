<?php

// Verifica o método da requisição
$method = $_SERVER['REQUEST_METHOD'];

// Define os clubes disponíveis
$clubes = ['Clube A', 'Clube B'];

// Define os tipos de recursos disponíveis
$recursos = ['Aluguel' => 10000, 'Passagem Aérea' => 20000];

// Define o array para armazenar a distribuição dos recursos
$distribuicao = [];

// Verifica o método da requisição
switch ($method) {
    case 'GET':
        // Retorna a distribuição atual dos recursos
        echo json_encode($distribuicao);
        break;
    case 'POST':
        // Obtém os dados enviados na requisição
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Verifica se os dados são válidos
        if (isset($data['clube']) && isset($data['recurso']) && isset($data['quantidade'])) {
            $clube = $data['clube'];
            $recurso = $data['recurso'];
            $quantidade = $data['quantidade'];
            
            // Verifica se o clube e o recurso são válidos
            if (in_array($clube, $clubes) && array_key_exists($recurso, $recursos)) {
                // Verifica se a quantidade solicitada é válida
                if ($quantidade > 0) {
                    // Verifica se há recursos disponíveis para distribuição
                    if ($recursos[$recurso] >= $quantidade) {
                        // Distribui os recursos para o clube selecionado
                        if (!isset($distribuicao[$clube])) {
                            $distribuicao[$clube] = [];
                        }
                        $distribuicao[$clube][$recurso] = $quantidade;
                        
                        // Subtrai a quantidade distribuída dos recursos disponíveis
                        $recursos[$recurso] -= $quantidade;
                        
                        // Retorna a distribuição atualizada dos recursos
                        echo json_encode($distribuicao);
                    } else {
                        echo "Recursos insuficientes para distribuição.";
                    }
                } else {
                    echo "A quantidade deve ser um número positivo.";
                }
            } else {
                echo "Clube ou recurso inválido.";
            }
        } else {
            echo "Dados inválidos na requisição.";
        }
        break;
    default:
        // Método não permitido
        header("HTTP/1.1 405 Method Not Allowed");
        echo "Método não permitido.";
        break;
}

function adicionarClube($nomeClube)
{
    // Carrega os clubes existentes do arquivo ou banco de dados
    $clubes = carregarClubes();

    // Verifica se o clube já existe
    if (in_array($nomeClube, $clubes)) {
        return false; // Retorna false se o clube já existir
    }

    // Adiciona o novo clube
    $clubes[] = $nomeClube;

    // Salva os clubes atualizados no arquivo ou banco de dados
    salvarClubes($clubes);

    return true; // Retorna true se o clube foi adicionado com sucesso
}

function adicionarRecurso($nomeRecurso, $valorRecurso)
{
    // Carrega os recursos existentes do arquivo ou banco de dados
    $recursos = carregarRecursos();

    // Verifica se o recurso já existe
    if (array_key_exists($nomeRecurso, $recursos)) {
        return false; // Retorna false se o recurso já existir
    }

    // Adiciona o novo recurso
    $recursos[$nomeRecurso] = $valorRecurso;

    // Salva os recursos atualizados no arquivo ou banco de dados
    salvarRecursos($recursos);

    return true; // Retorna true se o recurso foi adicionado com sucesso
}

// Exemplo de implementação das funções de carregamento e salvamento em arquivo
function carregarClubes()
{
    $clubes = []; // Array vazio para armazenar os clubes

    // Implemente aqui o código para carregar os clubes de um arquivo ou banco de dados

    return $clubes;
}

function salvarClubes($clubes)
{
    // Implemente aqui o código para salvar os clubes em um arquivo ou banco de dados
}

function carregarRecursos()
{
    $recursos = []; // Array vazio para armazenar os recursos

    // Implemente aqui o código para carregar os recursos de um arquivo ou banco de dados

    return $recursos;
}

function salvarRecursos($recursos)
{
    // Implemente aqui o código para salvar os recursos em um arquivo ou banco de dados
}
