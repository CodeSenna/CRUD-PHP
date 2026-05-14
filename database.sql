CREATE DATABASE IF NOT EXISTS devdb;
USE devdb;

CREATE TABLE IF NOT EXISTS chamados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    prioridade ENUM('baixa', 'media', 'alta') NOT NULL,
    status ENUM('aberto', 'andamento', 'fechado') DEFAULT 'aberto',
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO chamados (titulo, descricao, prioridade, status) VALUES 
('Erro no Servidor', 'O servidor Apache não está iniciando corretamente.', 'alta', 'aberto'),
('Ajuste de CSS', 'O cabeçalho não está responsivo em telas pequenas.', 'baixa', 'andamento');