<?php
require_once __DIR__ . '/../config/database.php';
if ($pdo && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM chamados WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}
header('Location: ../index.php');
exit;
