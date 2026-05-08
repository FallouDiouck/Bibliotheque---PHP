<?php
session_start();

require_once '../../header.php';
include '../../navbar.php';

$errorMessage = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<main>
    <div class="container py-5" style="max-width: 480px;">

        <?php if ($errorMessage): ?>
            <div class="alert-custom mb-4">
                <i class="bi bi-exclamation-circle me-2"></i><?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>

        <div style="text-align:center; margin-bottom:32px;">
            <i class="bi bi-shield-lock" style="font-size:40px; color:var(--gold);"></i>
            <h1 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:28px; margin-top:12px;">Changer le mot de passe</h1>
            <p style="color:var(--text-muted); font-size:14px;">Choisissez un nouveau mot de passe sécurisé</p>
        </div>

        <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:14px; padding:32px;">
            <form action="/action/profil/changer_mdp_action.php" method="POST">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

                <div class="mb-4">
                    <label for="current_password" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                        <i class="bi bi-lock me-1"></i>Mot de passe actuel
                    </label>
                    <input type="password" id="current_password" name="current_password"
                        placeholder="Votre mot de passe actuel"
                        style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                        onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                </div>

                <div style="height:1px; background:var(--border); margin-bottom:20px;"></div>

                <div class="mb-4">
                    <label for="new_password" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                        <i class="bi bi-lock-fill me-1"></i>Nouveau mot de passe
                    </label>
                    <input type="password" id="new_password" name="new_password"
                        placeholder="Votre nouveau mot de passe"
                        style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                        onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                </div>

                <div class="mb-4">
                    <label for="confirm_password" style="color:var(--text-muted); font-size:13px; font-weight:500; display:block; margin-bottom:8px;">
                        <i class="bi bi-lock-fill me-1"></i>Confirmer le nouveau mot de passe
                    </label>
                    <input type="password" id="confirm_password" name="confirm_password"
                        placeholder="Confirmez votre nouveau mot de passe"
                        style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                        onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                </div>

                <div style="display:flex; gap:12px; margin-top:8px;">
                    <button type="submit" class="btn-borrow" style="flex:1;">
                        <i class="bi bi-check-lg me-2"></i>Changer le mot de passe
                    </button>
                    <a href="/views/profil/profil.php" class="btn-outline-custom" style="white-space:nowrap; padding:10px 20px;">
                        <i class="bi bi-arrow-left me-1"></i>Retour
                    </a>
                </div>

            </form>
        </div>

    </div>
</main>

<?php include '../../footer.php'; ?>