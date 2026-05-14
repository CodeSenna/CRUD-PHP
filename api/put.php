<?php
require_once __DIR__ . '/../config/database.php';
if ($pdo && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE chamados SET titulo = ?, descricao = ?, prioridade = ?, status = ? WHERE id = ?");
    $stmt->execute([$_POST['titulo'], $_POST['descricao'], $_POST['prioridade'], $_POST['status'], $_POST['id']]);
}
header('Location: ../index.php');
exit;
