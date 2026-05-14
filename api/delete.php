<?php
require_once '../core/initialize.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    $stmt = $pdo->prepare("DELETE FROM chamados WHERE id = ?");
    $stmt->execute([$id]);
    
    $_SESSION['mensagem'] = "Chamado excluído com sucesso!";
    $_SESSION['tipo_msg'] = "warning";
}

header('Location: ../index.php');
exit;
?>