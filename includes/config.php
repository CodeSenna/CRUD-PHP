<?php

// ================================================
// Configuração do Banco de Dados - Supabase (PostgreSQL)
// ================================================



// ================================================
// Conexão PDO
// ================================================

function getConnection(): PDO {
    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        DB_HOST,
        DB_PORT,
        DB_NAME
    );

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    } catch (PDOException $e) {
        http_response_code(500);
        die(json_encode([
            'error'   => 'Falha na conexão com o banco de dados.',
            'message' => $e->getMessage()
        ]));
    }
}