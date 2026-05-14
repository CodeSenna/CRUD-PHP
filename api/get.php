<?php
require_once '../core/initialize.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM chamados WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $chamado = $stmt->fetch();

    header('Content-Type: application/json');
    echo json_encode($chamado);
    exit;
}
?>