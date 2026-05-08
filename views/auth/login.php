<?php
session_start();
$login = true;

include '../../header.php';
include '../../navbar.php';
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<main>
    <div class="container py-5" style="max-width: 480px;">

        <?php if (isset($error)): ?>
            <div class="alert-custom mb-4">
                <i class="bi bi-exclamation-circle me-2"></i><?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div style="text-align:center; margin-bottom: 32px;">
            <i class="bi bi-book-half" style="font-size:40px; color:var(--gold);"></i>
            <h1 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:28px; margin-top:12px;">Connexion</h1>
            <p style="color:var(--text-muted); font-size:14px;">Accédez à votre espace lecture</p>
        </div>

        <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:14px; padding:32px;">
            <form action="/action/auth/login_action.php" method="POST">

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
                        placeholder="Votre mot de passe"
                        style="width:100%; background:var(--bg-surface); border:1px solid var(--border); color:var(--text-main); border-radius:8px; padding:10px 14px; font-size:14px; outline:none; font-family:'DM Sans',sans-serif;"
                        onfocus="this.style.borderColor='var(--gold)'; this.style.boxShadow='0 0 0 3px rgba(201,169,110,0.12)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                </div>

                <button type="submit" class="btn-borrow" style="margin-top:8px;">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                </button>
            </form>
        </div>

        <p style="text-align:center; margin-top:20px; color:var(--text-muted); font-size:13px;">
            Pas encore de compte ?
            <a href="/views/auth/register.php" style="color:var(--gold); text-decoration:none; font-weight:500;">Créer un compte</a>
        </p>

    </div>
</main>

<?php include '../../footer.php'; ?>