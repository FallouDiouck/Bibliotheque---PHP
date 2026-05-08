<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /index.php');
    exit;
}

$dashboard = true;
include '../header.php';
include '../navbar.php';

require_once '../database/db_connection.php';
require_once '../database/dashboard_db.php';

// ── Statistiques globales ──────────────────────────────────────────────
$totalLivres     = getTotalLivres();
$totalAdherents  = getTotalAdherents();
$totalEmprunts   = getTotalEmprunts();
$empruntsEnCours = getEmpruntsEnCours();
$empruntsRetard  = getEmpruntsEnRetard();
$livresDisponibles = getLivresDisponibles();

// ── Emprunts des 6 derniers mois ───────────────────────────────────────
$empruntsParMois = getEmpruntsParMois();

// ── Top 5 livres les plus empruntés ────────────────────────────────────
$topLivres = getTopLivres();

// ── Derniers emprunts ──────────────────────────────────────────────────
$derniersEmprunts = getDerniersEmprunts();

// ── Répartition par catégorie ──────────────────────────────────────────
$parCategorie = getLivresParCategorie();
   
?>

<main>
<div class="container py-5">

    <!-- Titre -->
    <div style="margin-bottom:36px;">
        <h1 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:32px;">
            <i class="bi bi-grid me-2"></i>Tableau de bord
        </h1>
        <p style="color:var(--text-muted); font-size:14px; margin-top:6px;">
            Vue d'ensemble de la bibliothèque — <?= date('d/m/Y') ?>
        </p>
    </div>

    <!-- ── Cartes statistiques ── -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:32px;" class="stats-grid">

        <?php
        $stats = [
            ['icon'=>'bi-journal-bookmark', 'label'=>'Livres enregistrés',  'value'=>$totalLivres,      'color'=>'var(--gold)'],
            ['icon'=>'bi-check-circle',     'label'=>'Livres disponibles',  'value'=>$livresDisponibles,'color'=>'#2ecc71'],
            ['icon'=>'bi-people',           'label'=>'Adhérents',           'value'=>$totalAdherents,   'color'=>'#5dade2'],
            ['icon'=>'bi-bookmark-check',   'label'=>'Total emprunts',      'value'=>$totalEmprunts,    'color'=>'#a29bfe'],
            ['icon'=>'bi-hourglass-split',  'label'=>'En cours',            'value'=>$empruntsEnCours,  'color'=>'#f0a500'],
            ['icon'=>'bi-exclamation-triangle','label'=>'En retard',        'value'=>$empruntsRetard,   'color'=>'#e74c3c']
        ];
        foreach ($stats as $s): ?>
            <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:22px; display:flex; align-items:center; gap:16px; transition:transform 0.2s, border-color 0.2s;"
                onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='<?= $s['color'] ?>44'"
                onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='var(--border)'">
                <div style="width:48px; height:48px; border-radius:10px; background:<?= $s['color'] ?>18; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="bi <?= $s['icon'] ?>" style="font-size:22px; color:<?= $s['color'] ?>;"></i>
                </div>
                <div>
                    <div style="font-size:26px; font-weight:700; color:var(--text-main); font-family:'Playfair Display',serif; line-height:1;"><?= $s['value'] ?></div>
                    <div style="color:var(--text-muted); font-size:12px; margin-top:4px;"><?= $s['label'] ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- ── Graphique emprunts + Catégories ── -->
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:20px; margin-bottom:32px;" class="chart-grid">

        <!-- Graphique barres -->
        <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:24px;">
            <h3 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:16px; margin-bottom:20px;">
                <i class="bi bi-bar-chart me-2"></i>Emprunts des 6 derniers mois
            </h3>
            <?php if (!empty($empruntsParMois)):
                $maxVal = max(array_column($empruntsParMois, 'total'));
            ?>
            <div style="display:flex; align-items:flex-end; gap:12px; height:140px;">
                <?php foreach ($empruntsParMois as $m): ?>
                    <?php $hauteur = $maxVal > 0 ? round(($m['total'] / $maxVal) * 120) : 4; ?>
                    <div style="flex:1; display:flex; flex-direction:column; align-items:center; gap:6px;">
                        <span style="color:var(--gold); font-size:12px; font-weight:600;"><?= $m['total'] ?></span>
                        <div style="width:100%; height:<?= $hauteur ?>px; background:linear-gradient(180deg, var(--gold), var(--gold-dark)); border-radius:6px 6px 0 0; transition:opacity 0.2s;"
                            onmouseover="this.style.opacity='0.8'"
                            onmouseout="this.style.opacity='1'"></div>
                        <span style="color:var(--text-muted); font-size:11px; text-align:center;"><?= $m['mois'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <div style="text-align:center; color:var(--text-muted); padding:40px 0; font-size:14px;">
                    <i class="bi bi-bar-chart" style="font-size:32px; display:block; margin-bottom:8px; color:var(--border);"></i>
                    Aucune donnée disponible
                </div>
            <?php endif; ?>
        </div>

        <!-- Catégories -->
        <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:24px;">
            <h3 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:16px; margin-bottom:20px;">
                <i class="bi bi-tag me-2"></i>Livres par catégorie
            </h3>
            <?php
            $colors = ['#c9a96e','#2ecc71','#5dade2','#a29bfe','#f0a500','#e74c3c','#fd79a8'];
            $totalCat = array_sum(array_column($parCategorie, 'total'));
            foreach ($parCategorie as $i => $cat):
                $pct = $totalCat > 0 ? round(($cat['total'] / $totalCat) * 100) : 0;
                $color = $colors[$i % count($colors)];
            ?>
                <div style="margin-bottom:14px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                        <span style="color:var(--text-main); font-size:13px;"><?= htmlspecialchars($cat['nom']) ?></span>
                        <span style="color:var(--text-muted); font-size:12px;"><?= $cat['total'] ?> (<?= $pct ?>%)</span>
                    </div>
                    <div style="background:var(--bg-surface); border-radius:20px; height:6px; overflow:hidden;">
                        <div style="width:<?= $pct ?>%; height:100%; background:<?= $color ?>; border-radius:20px; transition:width 0.6s ease;"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ── Top livres + Derniers emprunts ── -->
    <div style="display:grid; grid-template-columns:1fr 2fr; gap:20px;" class="bottom-grid">

        <!-- Top livres -->
        <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; padding:24px;">
            <h3 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:16px; margin-bottom:20px;">
                <i class="bi bi-trophy me-2"></i>Top livres empruntés
            </h3>
            <?php foreach ($topLivres as $i => $liv): ?>
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px; padding-bottom:14px; <?= $i < count($topLivres)-1 ? 'border-bottom:1px solid var(--border);' : '' ?>">
                    <div style="width:28px; height:28px; border-radius:50%; background:<?= $i === 0 ? 'var(--gold)' : 'var(--bg-surface)' ?>; color:<?= $i === 0 ? '#0f1117' : 'var(--text-muted)' ?>; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0;">
                        <?= $i + 1 ?>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="color:var(--text-main); font-size:13px; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            <?= htmlspecialchars($liv['titre']) ?>
                        </div>
                        <div style="color:var(--text-muted); font-size:11px;"><?= htmlspecialchars($liv['auteur']) ?></div>
                    </div>
                    <span style="background:var(--bg-surface); color:var(--gold); font-size:11px; padding:2px 8px; border-radius:20px; flex-shrink:0;">
                        <?= $liv['nb_emprunts'] ?>x
                    </span>
                </div>
            <?php endforeach; ?>
            <?php if (empty($topLivres)): ?>
                <p style="color:var(--text-muted); font-size:13px; text-align:center; padding:20px 0;">Aucun emprunt enregistré</p>
            <?php endif; ?>
        </div>

        <!-- Derniers emprunts -->
        <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:12px; overflow:hidden;">
            <div style="padding:24px 24px 16px;">
                <h3 style="font-family:'Playfair Display',serif; color:var(--gold); font-size:16px;">
                    <i class="bi bi-clock-history me-2"></i>Derniers emprunts
                </h3>
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:var(--bg-surface); border-top:1px solid var(--border); border-bottom:1px solid var(--border);">
                        <th style="padding:10px 20px; color:var(--text-muted); font-weight:500; text-align:left;">Adhérent</th>
                        <th style="padding:10px 20px; color:var(--text-muted); font-weight:500; text-align:left;">Livre</th>
                        <th style="padding:10px 20px; color:var(--text-muted); font-weight:500; text-align:center;">Date</th>
                        <th style="padding:10px 20px; color:var(--text-muted); font-weight:500; text-align:center;">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($derniersEmprunts as $i => $emp): ?>
                        <?php
                        $enRetard = !$emp['date_retour'] && date('Y-m-d') > $emp['date_limite'];
                        ?>
                        <tr style="border-bottom:1px solid var(--border); <?= $i % 2 !== 0 ? 'background:rgba(255,255,255,0.02)' : '' ?>">
                            <td style="padding:12px 20px; color:var(--text-main);">
                                <?= htmlspecialchars($emp['prenom'] . ' ' . $emp['nom']) ?>
                            </td>
                            <td style="padding:12px 20px; color:var(--text-muted); max-width:160px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                <?= htmlspecialchars($emp['titre']) ?>
                            </td>
                            <td style="padding:12px 20px; color:var(--text-muted); text-align:center;">
                                <?= date('d/m/Y', strtotime($emp['date_emprunt'])) ?>
                            </td>
                            <td style="padding:12px 20px; text-align:center;">
                                <?php if ($emp['date_retour']): ?>
                                    <span class="badge-available">● Retourné</span>
                                <?php elseif ($enRetard): ?>
                                    <span class="badge-unavailable">● En retard</span>
                                <?php else: ?>
                                    <span style="display:inline-block; background:#2b2200; color:#f0a500; font-size:11px; padding:3px 12px; border-radius:20px; font-weight:500;">● En cours</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($derniersEmprunts)): ?>
                        <tr><td colspan="4" style="padding:30px; text-align:center; color:var(--text-muted);">Aucun emprunt enregistré</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>
</main>

<style>
@media (max-width: 768px) {
    .stats-grid  { grid-template-columns: repeat(2, 1fr) !important; }
    .chart-grid  { grid-template-columns: 1fr !important; }
    .bottom-grid { grid-template-columns: 1fr !important; }
}
@media (max-width: 480px) {
    .stats-grid { grid-template-columns: 1fr !important; }
}
</style>

<?php include '../footer.php'; ?>