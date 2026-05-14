<?php
require_once '../core/initialize.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $prioridade = $_POST['prioridade'] ?? 'baixa';
    $status = 'aberto'; // Chamado novo sempre entra como aberto por padrão

    if (!empty($titulo) && !empty($descricao)) {
        $stmt = $pdo->prepare("INSERT INTO chamados (titulo, descricao, prioridade, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $descricao, $prioridade, $status]);
        
        $_SESSION['mensagem'] = "Chamado cadastrado com sucesso!";
        $_SESSION['tipo_msg'] = "success";
    } else {
        $_SESSION['mensagem'] = "Preencha os campos obrigatórios.";
        $_SESSION['tipo_msg'] = "danger";
    }
    
    header('Location: ../index.php');
    exit;
}
?>