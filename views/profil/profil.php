<?php
session_start();
$profil = true;

include '../../header.php';
include '../../navbar.php';

require_once '../../database/user_db.php';

$user = getUserById($_SESSION['user_id']);
$message = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
?>

<main>
    <div class="container py-5" style="max-width: 900px;">

        <?php if ($message): ?>
            <div style="background:var(--green-bg); border:1px solid var(--green-text); color:var(--green-text); border-radius:10px; padding:14px 20px; font-size:14px; margin-bottom:24px;">
                <i class="bi bi-check-circle me-2"></i><?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div style="margin-bottom:32px;">
            <h1 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:30px;">
                <i class="bi bi-person-circle me-2"></i>Mon Profil
            </h1>
            <p style="color:var(--text-muted); font-size:14px; margin-top:6px;">Gérez vos informations personnelles</p>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;" class="profile-grid">

            <!-- Infos -->
            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:14px; padding:28px;">
                <h3 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:18px; margin-bottom:20px;">
                    <i class="bi bi-info-circle me-2"></i>Informations Personnelles
                </h3>

                <div style="margin-bottom:14px;">
                    <span style="color:var(--text-muted); font-size:12px; text-transform:uppercase; letter-spacing:0.8px;">Nom</span>
                    <p style="color:var(--text-main); font-size:15px; font-weight:500; margin-top:4px;"><?= htmlspecialchars($user['nom'] ?? '') ?></p>
                </div>
                <div style="margin-bottom:14px; border-top:1px solid var(--border); padding-top:14px;">
                    <span style="color:var(--text-muted); font-size:12px; text-transform:uppercase; letter-spacing:0.8px;">Prénom</span>
                    <p style="color:var(--text-main); font-size:15px; font-weight:500; margin-top:4px;"><?= htmlspecialchars($user['prenom'] ?? '') ?></p>
                </div>
                <div style="margin-bottom:24px; border-top:1px solid var(--border); padding-top:14px;">
                    <span style="color:var(--text-muted); font-size:12px; text-transform:uppercase; letter-spacing:0.8px;">Email</span>
                    <p style="color:var(--text-main); font-size:15px; font-weight:500; margin-top:4px;"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                </div>

                <div style="display:flex; flex-direction:column; gap:10px;">
                    <a href="/views/profil/changer_mdp.php" class="btn-outline-custom" style="text-align:center;">
                        <i class="bi bi-shield-lock me-2"></i>Changer le mot de passe
                    </a>
                    <a href="/views/Emprunts/livre_emprunte.php" class="btn-primary-custom" style="text-align:center;">
                        <i class="bi bi-bookmark-check me-2"></i>Voir mes emprunts
                    </a>
                </div>
            </div>

            <!-- Modifier -->
            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:14px; padding:28px;">
                <h3 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:18px; margin-bottom:20px;">
                    <i class="bi bi-pencil me-2"></i>Modifier mes informations
                </h3>

                <form action="/action/profil/profil_action.php" method="POST">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

                    <div class="mb-3">
                        <label for="nom" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">Nom</label>
                        <input type="text" id="nom" name="nom"
                            value="<?= htmlspecialchars($user['nom'] ?? '') ?>"
                            style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                            onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                            onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                    </div>

                    <div class="mb-3">
                        <label for="prenom" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">Prénom</label>
                        <input type="text" id="prenom" name="prenom"
                            value="<?= htmlspecialchars($user['prenom'] ?? '') ?>"
                            style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                            onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                            onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                    </div>

                    <div class="mb-4">
                        <label for="email" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">Email</label>
                        <input type="email" id="email" name="email"
                            value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                            style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                            onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                            onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                    </div>

                    <button type="submit" class="btn-borrow">
                        <i class="bi bi-check-lg me-2"></i>Enregistrer les modifications
                    </button>
                </form>
            </div>

        </div>

    </div>
</main>

<style>
    @media (max-width: 768px) {
        .profile-grid { grid-template-columns: 1fr !important; }
    }
</style>

<?php include '../../footer.php'; ?>