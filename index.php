<?php

session_start();
require_once 'database/db_connection.php';
require_once 'database/livre_db.php';
require_once 'database/categorie_db.php';
$index = true;

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: /views/dashboard.php');
    exit;
}

include 'navbar.php';
include 'header.php';

if(isset($_GET['search']) && !empty($_GET['search'])){
    $searchTerm = $_GET['search'];
    $livres = searchLivres($searchTerm);
    if(empty($livres)){
        $_SESSION['error'] = "Aucun livre trouvé pour : " . htmlspecialchars($searchTerm);
        unset($_SESSION['error']);
        $livres = getAllLivres();
    }
} else {
    $livres = getAllLivres();
}

$categories = getAllCategories();
$erreurMessage = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

?>

<main>
    <div class="container py-4">

        <?php if (isset($erreurMessage)): ?>
            <div class="alert-custom mb-4">
                <i class="bi bi-exclamation-circle me-2"></i><?php echo $erreurMessage; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'user'): ?>

            <!-- Hero -->
            <div class="hero-section">
                <h1>Bonjour, <?= htmlspecialchars($_SESSION['user_prenom'] ?? 'Lecteur') ?> 👋</h1>
                <p>Découvrez notre collection de livres passionnante. Explorez, empruntez, et laissez-vous emporter par des histoires fascinantes.</p>
            </div>

            <!-- Grille de livres -->
            <?php if (!empty($livres)): ?>
                <div class="row g-4 mt-2">
                    <?php foreach ($livres as $livre): ?>
                        <div class="col-md-4">
                            <div class="book-card h-100">
                                <div class="book-spine"></div>
                                <div class="book-body">

                                    <?php if ($livre['nbr_livre'] > 0): ?>
                                        <span class="badge-available">● Disponible</span>
                                    <?php else: ?>
                                        <span class="badge-unavailable">● Indisponible</span>
                                    <?php endif; ?>

                                    <div class="book-title"><?php echo htmlspecialchars($livre['titre']); ?></div>

                                    <?php if ($livre['nbr_livre'] > 0): ?>
                                        <div class="book-meta">
                                            <strong style="color:var(--text-main)">Auteur :</strong> <?php echo htmlspecialchars($livre['auteur']); ?><br>
                                            <strong style="color:var(--text-main)">Année :</strong> <?php echo htmlspecialchars($livre['annee']); ?><br>
                                            <strong style="color:var(--text-main)">Catégorie :</strong> <?php echo htmlspecialchars($livre['categorie_nom']); ?><br>
                                            <strong style="color:var(--text-main)">Quantité :</strong> <?php echo htmlspecialchars($livre['nbr_livre']); ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="book-meta">
                                            Ce livre est actuellement indisponible.
                                        </div>
                                    <?php endif; ?>

                                    <form action="/action/emprunt/emprunt_action.php" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment emprunter ce livre ?');">
                                        <input type="hidden" name="livre_id" value="<?php echo $livre['id']; ?>">
                                        <button type="submit" class="btn-borrow"
                                            <?= ($livre['nbr_livre'] <= 0) ? 'disabled' : '' ?>>
                                            <i class="bi bi-bookmark-plus me-1"></i>
                                            <?= $livre['nbr_livre'] > 0 ? 'Emprunter' : 'Indisponible' ?>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <div class="empty-state">
                    <i class="bi bi-book d-block"></i>
                    <h3 style="font-family:'Playfair Display',serif;color:var(--text-muted)">Aucun livre disponible</h3>
                    <p>Notre collection est vide pour le moment. Revenez bientôt !</p>
                </div>
            <?php endif; ?>

        <?php elseif (!isset($_SESSION['user_id'])): ?>

            <!-- Page visiteur -->
            <div class="guest-section">
                <i class="bi bi-book-half" style="font-size:52px;color:var(--gold);display:block;margin-bottom:20px;"></i>
                <h2>Bienvenue dans notre Bibliothèque</h2>
                <p>
                    Découvrez une collection variée de livres pour tous les goûts. Connectez-vous ou créez un compte
                    pour explorer nos titres, les emprunter et rejoindre notre communauté de lecteurs passionnés.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="/views/auth/login.php" class="btn-primary-custom">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                    </a>
                    <a href="/views/auth/register.php" class="btn-outline-custom">
                        <i class="bi bi-person-plus me-2"></i>Créer un compte
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php include 'footer.php'; ?>