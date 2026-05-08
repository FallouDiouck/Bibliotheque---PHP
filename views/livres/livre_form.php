<?php
session_start();

include '../../header.php';
include '../../navbar.php';
require_once '../../database/categorie_db.php';
require_once '../../database/livre_db.php';

$errorMessage = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $livres = getLivreById($id);
}

$categories = getAllCategories();
$isEdit = isset($livres);
?>

<main>
    <div class="container py-5" style="max-width: 600px;">

        <?php if (isset($errorMessage)): ?>
            <div class="alert-custom mb-4">
                <i class="bi bi-exclamation-circle me-2"></i><?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <div style="text-align:center; margin-bottom:32px;">
            <i class="bi bi-<?= $isEdit ? 'pencil-square' : 'plus-circle' ?>" style="font-size:40px; color:var(--gold);"></i>
            <h1 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:28px; margin-top:12px;">
                <?= $isEdit ? "Modifier le livre" : "Ajouter un livre" ?>
            </h1>
            <p style="color:var(--text-muted); font-size:14px;">
                <?= $isEdit ? "Mettez à jour les informations du livre" : "Enregistrez un nouveau livre dans la bibliothèque" ?>
            </p>
        </div>

        <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:14px; padding:32px;">
            <form action="/action/livre/livre_action.php" method="POST">
                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($livres['id']) ?>">
                <?php endif; ?>

                <div class="mb-4">
                    <label for="titre" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                        <i class="bi bi-book me-1"></i>Titre
                    </label>
                    <input type="text" id="titre" name="titre"
                        placeholder="Titre du livre"
                        value="<?= $isEdit ? htmlspecialchars($livres['titre']) : '' ?>"
                        style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                        onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                </div>

                <div class="mb-4">
                    <label for="auteur" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                        <i class="bi bi-person me-1"></i>Auteur
                    </label>
                    <input type="text" id="auteur" name="auteur"
                        placeholder="Nom de l'auteur"
                        value="<?= $isEdit ? htmlspecialchars($livres['auteur']) : '' ?>"
                        style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                        onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;" class="mb-4">
                    <div>
                        <label for="annee" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                            <i class="bi bi-calendar me-1"></i>Année de publication
                        </label>
                        <input type="date" id="annee" name="annee"
                            value="<?= $isEdit ? htmlspecialchars($livres['annee']) : '' ?>"
                            style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif; color-scheme:dark;"
                            onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                            onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label for="nbr_livre" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                            <i class="bi bi-stack me-1"></i>Quantité
                        </label>
                        <input type="number" id="nbr_livre" name="nbr_livre"
                            placeholder="0"
                            min="0"
                            value="<?= $isEdit ? htmlspecialchars($livres['nbr_livre']) : 0 ?>"
                            style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                            onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                            onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="categorie" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                        <i class="bi bi-tag me-1"></i>Catégorie
                    </label>
                    <select name="categorie_id" id="categorie"
                        style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif; cursor:pointer;"
                        onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                        <option value="" style="background:var(--bg-card);">Choisir une catégorie</option>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?php echo $categorie['id']; ?>"
                                style="background:var(--bg-card);"
                                <?= $isEdit && $livres['categorie_id'] == $categorie['id'] ? 'selected' : '' ?>>
                                <?php echo htmlspecialchars($categorie['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="display:flex; gap:12px; margin-top:8px;">
                    <button type="submit" class="btn-borrow" style="flex:1;">
                        <i class="bi bi-<?= $isEdit ? 'check-lg' : 'plus-lg' ?> me-2"></i>
                        <?= $isEdit ? "Enregistrer les modifications" : "Ajouter le livre" ?>
                    </button>
                    <a href="/views/livres/livre.php" class="btn-outline-custom" style="flex:0; white-space:nowrap; padding:10px 20px;">
                        <i class="bi bi-x-lg me-1"></i>Annuler
                    </a>
                </div>

            </form>
        </div>

    </div>
</main>

<?php include '../../footer.php'; ?>