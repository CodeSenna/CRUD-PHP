<?php
// ATENÇÃO: Conexão com o banco comentada para testar apenas a interface (Front-end)
// require_once 'core/initialize.php';

// Criando um array com dados falsos (Mock) para ver a tabela preenchida
$chamados = [
    [
        'id' => 1,
        'titulo' => 'teste 1',
        'descricao' => 'Falha ao integrar o frontend em Flutter com a API. Verificar logs.',
        'prioridade' => 'alta',
        'status' => 'aberto',
        'data_criacao' => date('Y-m-d H:i:s')
    ],
    [
        'id' => 2,
        'titulo' => 'teste 2',
        'descricao' => 'Ajustar no Inkscape: o texto não pode passar de 6cm de altura máximo.',
        'prioridade' => 'media',
        'status' => 'andamento',
        'data_criacao' => date('Y-m-d H:i:s', strtotime('-1 day'))
    ],
    [
        'id' => 3,
        'titulo' => 'teste 3',
        'descricao' => 'Iniciar produção de 35 peças (12P, 12M, 7G, 4GG) no tecido 20.1 220gsm.',
        'prioridade' => 'baixa',
        'status' => 'fechado',
        'data_criacao' => date('Y-m-d H:i:s', strtotime('-3 days'))
    ]
];

// Variável vazia apenas para não dar erro no filtro do HTML
$filtro_status = '';

// Desafio Extra: Destacar chamados por prioridade (cores)
function getCorPrioridade($prioridade) {
    switch ($prioridade) {
        case 'alta': return 'bg-danger';
        case 'media': return 'bg-warning text-dark';
        case 'baixa': return 'bg-info text-dark';
        default: return 'bg-secondary';
    }
}

// Cor para os status
function getCorStatus($status) {
    switch ($status) {
        case 'aberto': return 'text-danger fw-bold';
        case 'andamento': return 'text-primary fw-bold';
        case 'fechado': return 'text-success fw-bold';
        default: return '';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Chamados | Help Desk</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-center">Gestão de Chamados - Help Desk</h2>

    <!-- Feedback de Ações (Alertas) -->
    <?php if (isset($_SESSION['mensagem'])): ?>
        <div class="alert alert-<?= $_SESSION['tipo_msg'] ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['mensagem'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php 
        // Limpa a mensagem após exibir
        unset($_SESSION['mensagem'], $_SESSION['tipo_msg']); 
        endif; 
    ?>

    <!-- Painel de Ações: Botão Novo e Filtro -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-primary" onclick="abrirModalNovo()">+ Novo Chamado</button>
        
        <form method="GET" class="d-flex">
            <select name="status" class="form-select me-2" onchange="alert('O filtro só funcionará quando o banco de dados for reativado.')">
                <option value="">Filtrar: Todos os Status</option>
                <option value="aberto">Aberto</option>
                <option value="andamento">Em Andamento</option>
                <option value="fechado">Fechado</option>
            </select>
        </form>
    </div>

    <!-- Tabela Listagem (READ) -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle m-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Prioridade</th>
                            <th>Status</th>
                            <th>Data Criação</th>
                            <th class="text-end pe-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($chamados) > 0): ?>
                            <?php foreach ($chamados as $c): ?>
                                <tr>
                                    <td>#<?= $c['id'] ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($c['titulo']) ?></td>
                                    <td><span class="badge <?= getCorPrioridade($c['prioridade']) ?>"><?= ucfirst($c['prioridade']) ?></span></td>
                                    <td class="<?= getCorStatus($c['status']) ?>"><?= ucfirst($c['status']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($c['data_criacao'])) ?></td>
                                    <td class="text-end pe-3">
                                        <!-- Botão Editar -->
                                        <button class="btn btn-sm btn-warning" onclick="abrirModalEditar(<?= $c['id'] ?>, '<?= addslashes($c['titulo']) ?>', '<?= addslashes($c['descricao']) ?>', '<?= $c['prioridade'] ?>', '<?= $c['status'] ?>')">Editar</button>
                                        <!-- Botão Excluir -->
                                        <button class="btn btn-sm btn-danger" onclick="alert('Esta exclusão é apenas visual. Conecte o banco para funcionar.')">Excluir</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">Nenhum chamado encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Compartilhado (Cadastro / Edição) -->
<div class="modal fade" id="modalChamado" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- O 'action' aponta para # temporariamente no modo Mock -->
            <form id="formChamado" method="POST" action="#" onsubmit="event.preventDefault(); alert('Modo visual: Conecte o BD para salvar.'); modalBase.hide();">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Novo Chamado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Campo Oculto para o ID (usado apenas na edição) -->
                    <input type="hidden" name="id" id="chamado_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required placeholder="Resumo do problema">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricao" class="form-control" rows="3" required placeholder="Detalhes do chamado..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prioridade</label>
                            <select name="prioridade" id="prioridade" class="form-select" required>
                                <option value="baixa">Baixa</option>
                                <option value="media">Média</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="aberto">Aberto</option>
                                <option value="andamento">Em Andamento</option>
                                <option value="fechado">Fechado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar Chamado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap e JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const modalBase = new bootstrap.Modal(document.getElementById('modalChamado'));
    const formChamado = document.getElementById('formChamado');

    function abrirModalNovo() {
        document.getElementById('modalTitle').innerText = 'Novo Chamado';
        formChamado.reset();                 
        document.getElementById('chamado_id').value = '';
        
        // Bloqueia alterar o status na criação
        document.getElementById('status').value = 'aberto';
        document.getElementById('status').disabled = true;
        
        modalBase.show();
    }

    // Função modificada temporariamente para receber os dados direto do botão e não da API (pois o banco está desligado)
    function abrirModalEditar(id, titulo, descricao, prioridade, status) {
        document.getElementById('status').disabled = false;
        document.getElementById('modalTitle').innerText = 'Editar Chamado #' + id;
        
        document.getElementById('chamado_id').value = id;
        document.getElementById('titulo').value = titulo;
        document.getElementById('descricao').value = descricao;
        document.getElementById('prioridade').value = prioridade;
        document.getElementById('status').value = status;
        
        modalBase.show();
    }
</script>
</body>
</html>