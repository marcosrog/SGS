<?php
require_once 'functions.php';

$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $quadra = $_POST['quadra'];
        $obs = $_POST['obs'];
        $stmt = $pdo->prepare('INSERT INTO quadras (quadra, obs) VALUES (?, ?)');
        $stmt->execute([$quadra, $obs]);
    }

    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $quadra = $_POST['quadra'];
        $obs = $_POST['obs'];
        $stmt = $pdo->prepare('UPDATE quadras SET quadra = ?, obs = ? WHERE id = ?');
        $stmt->execute([$quadra, $obs, $id]);
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare('DELETE FROM quadras WHERE id = ?');
        $stmt->execute([$id]);
    }
}

$stmt = $pdo->query('SELECT * FROM quadras ORDER BY quadra');
$quadras = $stmt->fetchAll();

?>

<h2>Gerenciar Quadras</h2>

<div class="card">
    <div class="card-header">
        Adicionar Nova Quadra
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quadra" class="form-label">Quadra</label>
                        <input type="text" class="form-control" id="quadra" name="quadra" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="obs" class="form-label">Observação</label>
                        <input type="text" class="form-control" id="obs" name="obs">
                    </div>
                </div>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Adicionar</button>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        Quadras Existentes
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Quadra</th>
                    <th>Observação</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quadras as $quadra): ?>
                    <tr>
                        <td><?= htmlspecialchars($quadra['quadra']) ?></td>
                        <td><?= htmlspecialchars($quadra['obs']) ?></td>
                        <td class="text-end">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?= $quadra['id'] ?>">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-<?= $quadra['id'] ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal-<?= $quadra['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Quadra</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?= $quadra['id'] ?>">
                                        <div class="mb-3">
                                            <label for="quadra-<?= $quadra['id'] ?>" class="form-label">Quadra</label>
                                            <input type="text" class="form-control" id="quadra-<?= $quadra['id'] ?>" name="quadra" value="<?= htmlspecialchars($quadra['quadra']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="obs-<?= $quadra['id'] ?>" class="form-label">Observação</label>
                                            <input type="text" class="form-control" id="obs-<?= $quadra['id'] ?>" name="obs" value="<?= htmlspecialchars($quadra['obs']) ?>">
                                        </div>
                                        <button type="submit" name="edit" class="btn btn-primary">Salvar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal-<?= $quadra['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Excluir Quadra</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Tem certeza que deseja excluir a quadra "<?= htmlspecialchars($quadra['quadra']) ?>"?</p>
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?= $quadra['id'] ?>">
                                        <button type="submit" name="delete" class="btn btn-danger">Excluir</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
