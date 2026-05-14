<?php
require_once '../core/initialize.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $prioridade = $_POST['prioridade'] ?? 'baixa';
    $status = $_POST['status'] ?? 'aberto';

    if ($id && !empty($titulo) && !empty($descricao)) {
        $stmt = $pdo->prepare("UPDATE chamados SET titulo = ?, descricao = ?, prioridade = ?, status = ? WHERE id = ?");
        $stmt->execute([$titulo, $descricao, $prioridade, $status, $id]);
        
        $_SESSION['mensagem'] = "Chamado atualizado com sucesso!";
        $_SESSION['tipo_msg'] = "success";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar. Verifique os dados.";
        $_SESSION['tipo_msg'] = "danger";
    }
    
    header('Location: ../index.php');
    exit;
}
?>