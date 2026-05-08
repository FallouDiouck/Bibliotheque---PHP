<?php
session_start();

$livre = true;
include '../../header.php';
include '../../navbar.php';

require_once '../../database/livre_db.php';
require_once '../../database/categorie_db.php';

if (isset($_GET['categorie']) && $_GET['categorie'] !== "") {
    $categorie_id = $_GET['categorie'];
    $livres = getLivreByCategorie($categorie_id);
} else {
    $livres = getAllLivres();
}

$categories = getAllCategories();
$successMessage = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
?>

<main>
    <div class="container py-5">
        <?php if (isset($successMessage)): ?>
            <div style="background:var(--green-bg); border:1px solid var(--green-text); color:var(--green-text); border-radius:10px; padding:14px 20px; font-size:14px; margin-bottom:24px;">
                <i class="bi bi-check-circle me-2"></i><?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        <!-- En-tête -->
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:32px;">
            <div>
                <h1 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:30px;">
                    <i class="bi bi-journal-bookmark me-2"></i>Gestion des Livres
                </h1>
                <p style="color:var(--text-muted); font-size:14px; margin-top:6px;">
                    <?= count($livres) ?> livre<?= count($livres) > 1 ? 's' : '' ?> enregistré<?= count($livres) > 1 ? 's' : '' ?>
                </p>
            </div>
            <form action="/views/livres/livre_form.php" method="POST">
                <button type="submit" class="btn-borrow" style="width:auto; padding:10px 22px;">
                    <i class="bi bi-plus-lg me-2"></i>Ajouter un livre
                </button>
            </form>
        </div>

        <!-- Filtre catégorie -->
        <div style="margin-bottom:20px;">
            <form action="" method="GET">
                <select name="categorie" onchange="this.form.submit()"
                    style="background:var(--bg-card); border:1px solid var(--border); color:var(--text-main); padding:9px 16px; border-radius:8px; font-size:13px; font-family:'DM Sans',sans-serif; outline:none; cursor:pointer;">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?php echo $categorie['id']; ?>"
                            style="background:var(--bg-card);"
                            <?= isset($_GET['categorie']) && $_GET['categorie'] == $categorie['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categorie['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <!-- Tableau -->
        <?php if (!empty($livres)): ?>
            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:14px; overflow:hidden;">
                <table style="width:100%; border-collapse:collapse; font-size:14px;">
                    <thead>
                        <tr style="background:var(--bg-surface); border-bottom:1px solid var(--border);">
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:left; font-family:'Playfair Display',serif;">Titre</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:left; font-family:'Playfair Display',serif;">Auteur</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:center; font-family:'Playfair Display',serif;">Année</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:center; font-family:'Playfair Display',serif;">Catégorie</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:center; font-family:'Playfair Display',serif;">Stock</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:center; font-family:'Playfair Display',serif;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($livres as $i => $livre): ?>
                            <tr style="border-bottom:1px solid var(--border); <?= $i % 2 === 0 ? '' : 'background:rgba(255,255,255,0.02)' ?>; transition:background 0.15s;"
                                onmouseover="this.style.background='rgba(201,169,110,0.05)'"
                                onmouseout="this.style.background='<?= $i % 2 === 0 ? 'transparent' : 'rgba(255,255,255,0.02)' ?>'">

                                <td style="padding:14px 20px; color:var(--text-main); font-weight:500; font-family:'Playfair Display',serif;">
                                    <?php echo htmlspecialchars($livre['titre']); ?>
                                </td>
                                <td style="padding:14px 20px; color:var(--text-muted);">
                                    <?php echo htmlspecialchars($livre['auteur']); ?>
                                </td>
                                <td style="padding:14px 20px; color:var(--text-muted); text-align:center;">
                                    <?php echo htmlspecialchars($livre['annee']); ?>
                                </td>
                                <td style="padding:14px 20px; text-align:center;">
                                    <span style="background:var(--bg-surface); color:var(--text-muted); font-size:11px; padding:3px 10px; border-radius:20px; border:1px solid var(--border);">
                                        <?php echo htmlspecialchars($livre['categorie_nom']); ?>
                                    </span>
                                </td>
                                <td style="padding:14px 20px; text-align:center;">
                                    <?php if ($livre['nbr_livre'] > 0): ?>
                                        <span class="badge-available">● <?= $livre['nbr_livre'] ?></span>
                                    <?php else: ?>
                                        <span class="badge-unavailable">● 0</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding:14px 20px; text-align:center;">
                                    <div style="display:flex; gap:8px; justify-content:center;">
                                        <form action="/views/livres/livre_form.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $livre['id']; ?>">
                                            <button type="submit"
                                                style="background:rgba(201,169,110,0.12); color:var(--gold); border:1px solid rgba(201,169,110,0.3); padding:6px 14px; border-radius:7px; font-size:12px; font-weight:500; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background 0.2s;"
                                                onmouseover="this.style.background='rgba(201,169,110,0.22)'"
                                                onmouseout="this.style.background='rgba(201,169,110,0.12)'">
                                                <i class="bi bi-pencil me-1"></i>Modifier
                                            </button>
                                        </form>
                                        <form action="/action/auth/livre_delete.php" method="POST"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
                                            <input type="hidden" name="id" value="<?php echo $livre['id']; ?>">
                                            <button type="submit"
                                                style="background:var(--red-bg); color:var(--red-text); border:1px solid rgba(231,76,60,0.3); padding:6px 14px; border-radius:7px; font-size:12px; font-weight:500; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background 0.2s;"
                                                onmouseover="this.style.background='rgba(231,76,60,0.2)'"
                                                onmouseout="this.style.background='var(--red-bg)'">
                                                <i class="bi bi-trash me-1"></i>Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-journal-x d-block"></i>
                <h3 style="font-family:'Playfair Display',serif; color:var(--text-muted);">Aucun livre trouvé</h3>
                <p>Aucun livre dans cette catégorie pour le moment.</p>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include '../../footer.php'; ?>