<?php
session_start();
$register = true;

include '../../header.php';
include '../../navbar.php';
require_once '../../database/user_db.php';

$errorMessage = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<main>
    <div class="container py-5" style="max-width: 520px;">

        <?php if (isset($errorMessage)): ?>
            <div class="alert-custom mb-4">
                <i class="bi bi-exclamation-circle me-2"></i><?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <div style="text-align:center; margin-bottom:32px;">
            <i class="bi bi-person-plus" style="font-size:40px; color:var(--gold);"></i>
            <h1 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:28px; margin-top:12px;">Créer un compte</h1>
            <p style="color:var(--text-muted); font-size:14px;">Rejoignez notre communauté de lecteurs</p>
        </div>

        <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:14px; padding:32px;">
            <form action="/action/auth/register_action.php" method="POST">

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;" class="mb-4">
                    <div>
                        <label for="nom" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                            <i class="bi bi-person me-1"></i>Nom
                        </label>
                        <input type="text" id="nom" name="nom"
                            placeholder="Votre nom"
                            style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                            onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                            onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label for="prenom" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                            <i class="bi bi-person me-1"></i>Prénom
                        </label>
                        <input type="text" id="prenom" name="prenom"
                            placeholder="Votre prénom"
                            style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                            onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                            onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                        <i class="bi bi-envelope me-1"></i>Adresse Email
                    </label>
                    <input type="email" id="email" name="email"
                        placeholder="nom@exemple.com"
                        style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                        onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                </div>

                <div class="mb-4">
                    <label for="password" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                        <i class="bi bi-lock me-1"></i>Mot de passe
                    </label>
                    <input type="password" id="password" name="password"
                        placeholder="Choisissez un mot de passe"
                        style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                        onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                </div>

                <button type="submit" class="btn-borrow" style="margin-top:8px;">
                    <i class="bi bi-person-check me-2"></i>S'inscrire
                </button>
            </form>
        </div>

        <p style="text-align:center; margin-top:20px; color:var(--text-muted); font-size:13px;">
            Déjà un compte ?
            <a href="/views/auth/login.php" style="color:var(--gold); text-decoration:none; font-weight:500;">Se connecter</a>
        </p>

    </div>
</main>

<?php include '../../footer.php'; ?>