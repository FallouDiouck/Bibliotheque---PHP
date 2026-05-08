<?php
session_start();

$emprunt = true;
include '../../header.php';
include '../../navbar.php';

require_once '../../database/emprunt_db.php';
require_once '../../database/livre_db.php';

$emprunts = getEmpruntByUser($_SESSION['user_id']);
$successMessage = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
?>

<main>
    <div class="container py-5">

        <?php if ($successMessage): ?>
            <div style="background:var(--green-bg); border:1px solid var(--green-text); color:var(--green-text); border-radius:10px; padding:14px 20px; font-size:14px; margin-bottom:24px;">
                <i class="bi bi-check-circle me-2"></i><?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <div style="margin-bottom:32px;">
            <h1 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:30px;">
                <i class="bi bi-bookmark-check me-2"></i>Mes Emprunts
            </h1>
            <p style="color:var(--text-muted); font-size:14px; margin-top:6px;">Historique de vos emprunts en cours et passés</p>
        </div>

        <?php if (!empty($emprunts)): ?>
            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:14px; overflow:hidden;">
                <table style="width:100%; border-collapse:collapse; font-size:14px;">
                    <thead>
                        <tr style="background:var(--bg-surface); border-bottom:1px solid var(--border);">
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:left; font-family:'Playfair Display',serif;">Livre</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:center; font-family:'Playfair Display',serif;">Date d'emprunt</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:center; font-family:'Playfair Display',serif;">Statut</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:center; font-family:'Playfair Display',serif;">Date de retour</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:center; font-family:'Playfair Display',serif;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($emprunts as $i => $emp): ?>
                            <?php $date_limite = date('Y-m-d', strtotime($emp['date_emprunt'] . ' +7 days')); ?>
                            <tr style="border-bottom:1px solid var(--border); <?= $i % 2 === 0 ? '' : 'background:rgba(255,255,255,0.02)' ?>;">
                                <td style="padding:14px 20px; color:var(--text-main); font-weight:500;">
                                    <i class="bi bi-book me-2" style="color:var(--gold);"></i>
                                    <?php echo htmlspecialchars($emp['titre_livre']); ?>
                                </td>
                                <td style="padding:14px 20px; color:var(--text-muted); text-align:center;">
                                    <?php echo htmlspecialchars($emp['date_emprunt']); ?>
                                </td>
                                <td style="padding:14px 20px; text-align:center;">
                                    <?php if ($emp['date_retour']): ?>
                                        <span class="badge-available">● Retourné</span>
                                    <?php elseif (date('Y-m-d') > $date_limite): ?>
                                        <span class="badge-unavailable">● En retard</span>
                                    <?php else: ?>
                                        <span style="display:inline-block; background:#2b2200; color:#f0a500; font-size:11px; padding:3px 12px; border-radius:20px; font-weight:500;">● En cours</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding:14px 20px; color:var(--text-muted); text-align:center;">
                                    <?php echo htmlspecialchars($emp['date_retour'] ?? '—'); ?>
                                </td>
                                <td style="padding:14px 20px; text-align:center;">
                                    <form action="/action/emprunt/emprunt_retour_action.php" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment retourner ce livre ?');">
                                        <input type="hidden" name="id" value="<?php echo $emp['id']; ?>">
                                        <input type="hidden" name="livre_id" value="<?php echo $emp['livre_id']; ?>">
                                        <button type="submit"
                                            style="background:<?= $emp['date_retour'] ? 'var(--bg-surface)' : 'var(--gold)' ?>; color:<?= $emp['date_retour'] ? 'var(--text-muted)' : '#0f1117' ?>; border:none; padding:7px 16px; border-radius:7px; font-size:13px; font-weight:600; cursor:<?= $emp['date_retour'] ? 'not-allowed' : 'pointer' ?>; font-family:'DM Sans',sans-serif;"
                                            <?= $emp['date_retour'] ? 'disabled' : '' ?>>
                                            <i class="bi bi-arrow-return-left me-1"></i>Retourner
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-bookmark d-block"></i>
                <h3 style="font-family:'Playfair Display',serif; color:var(--text-muted);">Aucun emprunt</h3>
                <p style="margin-bottom:24px;">Vous n'avez effectué aucun emprunt pour l'instant.</p>
                <a href="/index.php" class="btn-primary-custom">
                    <i class="bi bi-house me-2"></i>Retour à l'accueil
                </a>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include '../../footer.php'; ?>