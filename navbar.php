<nav class="navbar navbar-expand-md navbar-custom fixed-top">
    <div class="container-fluid px-4">
        <a href="/index.php" class="navbar-brand-custom">
            <i class="bi bi-book-half me-2"></i>Ma Bibliothèque
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-md-0 ms-3">
                <li class="nav-item">
                    <a class="nav-link <?= isset($index) || isset($dashboard) ? 'active' : '' ?>" href="<?= isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin' ? '/views/dashboard.php' : '/index.php' ?>">
                        <i class="bi bi-house me-1"></i>Accueil
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($livre) ? 'active' : '' ?>" href="/views/livres/livre.php">
                            <i class="bi bi-journal-bookmark me-1"></i>Livres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($adh) ? 'active' : '' ?>" href="/views/adherents/adherent.php">
                            <i class="bi bi-people me-1"></i>Adhérents
                        </a>
                    </li>

                <?php elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'user'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($emprunt) ? 'active' : '' ?>" href="/views/Emprunts/livre_emprunte.php">
                            <i class="bi bi-bookmark-check me-1"></i>Mes Emprunts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($profil) ? 'active' : '' ?>" href="/views/profil/profil.php">
                            <i class="bi bi-person-circle me-1"></i>Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($reser) ? 'active' : '' ?>" href="/views/reservations/mes_reservations.php">
                            <i class="bi bi-calendar-check me-1"></i>Mes Réservations
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($login) ? 'active' : '' ?>" href="/views/auth/login.php">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($register) ? 'active' : '' ?>" href="/views/auth/register.php">
                            <i class="bi bi-person-plus me-1"></i>Inscription
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="d-flex align-items-center gap-3">
                    <form action="" method="GET" class="mb-0">
                        <input type="search" name="search" class="search-input"
                            placeholder="🔍  Rechercher un livre...">
                    </form>
                    <form action="/action/auth/logout_action.php" class="mb-0">
                        <button class="btn-logout-custom" type="submit">
                            <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Spacer pour compenser la navbar fixed -->
<div style="height: 68px;"></div>