<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Chamados | Help Desk</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .badge-alta { background-color: #dc3545; }
        .badge-media { background-color: #ffc107; color: #000; }
        .badge-baixa { background-color: #0dcaf0; color: #000; }

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
        }
    </style>
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Help Desk Acadêmico</span>
        <span class="navbar-text text-white-50 d-none d-md-inline">
            Integrantes: Matheus Senna & Gabriel Brochi
        </span>
    </div>
</nav>