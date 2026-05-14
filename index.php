<!-- MATHEUS SENNA E GABRIEL BROCHI -->
<?php
require_once __DIR__ . '/config/database.php';
include_once __DIR__ . '/includes/header.php';

$filtro_status = isset($_GET['status']) ? trim((string) $_GET['status']) : '';

if ($pdo) {
    if ($filtro_status !== '') {
        $stmt = $pdo->prepare('SELECT * FROM chamados WHERE status = ? ORDER BY data_criacao DESC');
        $stmt->execute([$filtro_status]);
    } else {
        $stmt = $pdo->query('SELECT * FROM chamados ORDER BY data_criacao DESC');
    }
    $chamados = $stmt->fetchAll();
} else {
    $chamados = [];
}

function getCorPrioridade($p) {
    return match($p) {
        'alta' => 'badge-alta',
        'media' => 'badge-media',
        'baixa' => 'badge-baixa',
        default => 'bg-secondary'
    };
}
?>

<div class="main-content">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestão de Chamados</h2>
            <button class="btn btn-primary" onclick="abrirModal()">+ Novo Chamado</button>
        </div>

        <?php if (!$pdo): ?>
            <div class="alert alert-warning shadow-sm">
                <strong>Atenção:</strong> Banco de dados local não conectado. Verifique o MySQL Workbench e o seu arquivo <code>.env</code>.
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <form method="GET" class="row g-2 align-items-center">
                    <div class="col-auto">
                        <label class="form-label mb-0">Filtrar por Status:</label>
                    </div>
                    <div class="col-auto">
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            <option value="aberto" <?= $filtro_status == 'aberto' ? 'selected' : '' ?>>Aberto</option>
                            <option value="andamento" <?= $filtro_status == 'andamento' ? 'selected' : '' ?>>Em Andamento</option>
                            <option value="fechado" <?= $filtro_status == 'fechado' ? 'selected' : '' ?>>Fechado</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Título</th>
                            <th>Prioridade</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($chamados as $c): ?>
                        <tr>
                            <td class="ps-3 text-muted">#<?= $c['id'] ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($c['titulo']) ?></td>
                            <td>
                                <span class="badge <?= getCorPrioridade($c['prioridade']) ?>">
                                    <?= ucfirst($c['prioridade']) ?>
                                </span>
                            </td>
                            <td class="text-capitalize"><?= $c['status'] ?></td>
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-outline-dark" onclick='editar(<?= json_encode($c) ?>)'>Editar</button>
                                <a href="api/delete.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir chamado?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if(empty($chamados)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    Nenhum chamado encontrado.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalChamado" tabindex="-1">
    <div class="modal-dialog">
        <form action="api/post.php" method="POST" class="modal-content" id="formChamado">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Novo Chamado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="chamado_id">

                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" id="descricao" class="form-control" rows="3" required></textarea>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Prioridade</label>
                        <select name="prioridade" id="prioridade" class="form-select">
                            <option value="baixa">Baixa</option>
                            <option value="media" selected>Média</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="aberto">Aberto</option>
                            <option value="andamento">Em Andamento</option>
                            <option value="fechado">Fechado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

        </form>
    </div>
</div>

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const modalEl = document.getElementById('modalChamado');
    const modal = new bootstrap.Modal(modalEl);

    window.abrirModal = function () {
        const form = document.getElementById('formChamado');

        form.reset();
        form.action = 'api/post.php';

        document.getElementById('modalTitle').innerText = 'Novo Chamado';
        document.getElementById('status').value = 'aberto';
        document.getElementById('chamado_id').value = '';

        modal.show();
    }

    window.editar = function (c) {
        const form = document.getElementById('formChamado');

        form.action = 'api/put.php';

        document.getElementById('modalTitle').innerText = 'Editar Chamado #' + c.id;
        document.getElementById('chamado_id').value = c.id;
        document.getElementById('titulo').value = c.titulo;
        document.getElementById('descricao').value = c.descricao;
        document.getElementById('prioridade').value = c.prioridade;
        document.getElementById('status').value = c.status;

        modal.show();
    }

});
</script>

<?php include_once __DIR__ . '/includes/footer.php'; ?>