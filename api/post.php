<?php
require_once __DIR__ . '/../config/database.php';
if ($pdo && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO chamados (titulo, descricao, prioridade, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['titulo'], $_POST['descricao'], $_POST['prioridade'], $_POST['status']]);
}
header('Location: ../index.php');
exit;
