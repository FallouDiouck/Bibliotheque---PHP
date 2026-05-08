<?php
session_start();

$adh = true;
require_once '../../database/user_db.php';
include '../../header.php';
include '../../navbar.php';

$adherents = getUserByRole('user');
?>

<main>
    <div class="container py-5">

        <div style="margin-bottom:32px;">
            <h1 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:30px;">
                <i class="bi bi-people me-2"></i>Liste des Adhérents
            </h1>
            <p style="color:var(--text-muted); font-size:14px; margin-top:6px;">
                <?= count($adherents) ?> adhérent<?= count($adherents) > 1 ? 's' : '' ?> enregistré<?= count($adherents) > 1 ? 's' : '' ?>
            </p>
        </div>

        <?php if (!empty($adherents)): ?>
            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:14px; overflow:hidden;">
                <table style="width:100%; border-collapse:collapse; font-size:14px;">
                    <thead>
                        <tr style="background:var(--bg-surface); border-bottom:1px solid var(--border);">
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:left; font-family:'Playfair Display',serif;">#</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:left; font-family:'Playfair Display',serif;">Nom</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:left; font-family:'Playfair Display',serif;">Prénom</th>
                            <th style="padding:14px 20px; color:var(--gold); font-weight:600; text-align:left; font-family:'Playfair Display',serif;">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($adherents as $i => $adherent): ?>
                            <tr style="border-bottom:1px solid var(--border); <?= $i % 2 === 0 ? '' : 'background:rgba(255,255,255,0.02)' ?>; transition:background 0.15s;"
                                onmouseover="this.style.background='rgba(201,169,110,0.05)'"
                                onmouseout="this.style.background='<?= $i % 2 === 0 ? 'transparent' : 'rgba(255,255,255,0.02)' ?>'">
                                <td style="padding:14px 20px; color:var(--text-muted); font-size:12px;">
                                    <?php echo htmlspecialchars($adherent['id']); ?>
                                </td>
                                <td style="padding:14px 20px; color:var(--text-main); font-weight:500;">
                                    <?php echo htmlspecialchars($adherent['nom']); ?>
                                </td>
                                <td style="padding:14px 20px; color:var(--text-main);">
                                    <?php echo htmlspecialchars($adherent['prenom']); ?>
                                </td>
                                <td style="padding:14px 20px; color:var(--text-muted);">
                                    <i class="bi bi-envelope me-1" style="color:var(--gold); font-size:12px;"></i>
                                    <?php echo htmlspecialchars($adherent['email']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-people d-block"></i>
                <h3 style="font-family:'Playfair Display',serif; color:var(--text-muted);">Aucun adhérent</h3>
                <p>Aucun adhérent enregistré pour le moment.</p>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include '../../footer.php'; ?>