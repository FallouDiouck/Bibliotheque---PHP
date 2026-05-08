<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ma Bibliothèque - Découvrez notre collection de livres">
    <title>Ma Bibliothèque</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* ===== Variables ===== */
        :root {
            --bg-main:    #0f1117;
            --bg-card:    #16162a;
            --bg-surface: #1a1a2e;
            --border:     #2a2a3a;
            --gold:       #c9a96e;
            --gold-dark:  #a07840;
            --text-main:  #e8e4d9;
            --text-muted: #7a7a95;
            --green-bg:   #0d2b1a;
            --green-text: #2ecc71;
            --red-bg:     #2b0d0d;
            --red-text:   #e74c3c;
        }

        /* ===== Base ===== */
        body {
            background-color: var(--bg-main);
            color: var(--text-main);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, .brand-name {
            font-family: 'Playfair Display', serif;
        }

        /* ===== Navbar ===== */
        .navbar-custom {
            background-color: var(--bg-main) !important;
            border-bottom: 1px solid var(--border);
            padding: 14px 24px;
        }

        .navbar-brand-custom {
            font-family: 'Playfair Display', serif;
            color: var(--gold) !important;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-decoration: none;
        }

        .navbar-nav .nav-link {
            color: var(--text-muted) !important;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
            padding: 6px 12px;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--gold) !important;
        }

        .search-input {
            background: var(--bg-surface) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-main) !important;
            border-radius: 20px !important;
            padding: 7px 16px !important;
            font-size: 13px;
            width: 200px;
            outline: none;
        }

        .search-input::placeholder { color: var(--text-muted); }
        .search-input:focus { border-color: var(--gold) !important; box-shadow: 0 0 0 3px rgba(201,169,110,0.12) !important; }

        .btn-logout-custom {
            background: transparent;
            border: 1px solid var(--red-text);
            color: var(--red-text);
            padding: 6px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }

        .btn-logout-custom:hover {
            background: var(--red-bg);
            color: var(--red-text);
        }

        .navbar-toggler {
            border-color: var(--border) !important;
        }

        .navbar-toggler-icon {
            filter: invert(0.6);
        }

        /* ===== Cards ===== */
        .book-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .book-card:hover {
            transform: translateY(-5px);
            border-color: rgba(201,169,110,0.35);
            box-shadow: 0 12px 32px rgba(0,0,0,0.4);
        }

        .book-spine {
            height: 6px;
            background: linear-gradient(90deg, var(--gold), var(--gold-dark));
        }

        .book-body {
            padding: 20px;
        }

        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            color: var(--text-main);
            margin-bottom: 8px;
            font-weight: 500;
        }

        .book-meta {
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.7;
            margin-bottom: 14px;
        }

        .badge-available {
            display: inline-block;
            background: var(--green-bg);
            color: var(--green-text);
            font-size: 11px;
            padding: 3px 12px;
            border-radius: 20px;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .badge-unavailable {
            display: inline-block;
            background: var(--red-bg);
            color: var(--red-text);
            font-size: 11px;
            padding: 3px 12px;
            border-radius: 20px;
            margin-bottom: 12px;
            font-weight: 500;
        }

        .btn-borrow {
            width: 100%;
            background: var(--gold);
            border: none;
            color: #0f1117;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: background 0.2s;
        }

        .btn-borrow:hover { background: var(--gold-dark); }

        .btn-borrow:disabled {
            background: var(--bg-surface);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        /* ===== Hero ===== */
        .hero-section {
            text-align: center;
            padding: 60px 24px 32px;
        }

        .hero-section h1 {
            font-size: 36px;
            color: var(--gold);
            margin-bottom: 12px;
        }

        .hero-section p {
            color: var(--text-muted);
            font-size: 15px;
            max-width: 540px;
            margin: 0 auto;
            line-height: 1.75;
        }

        /* ===== Alerts ===== */
        .alert-custom {
            background: var(--red-bg);
            border: 1px solid var(--red-text);
            color: var(--red-text);
            border-radius: 10px;
            padding: 14px 20px;
            font-size: 14px;
        }

        /* ===== Guest section ===== */
        .guest-section {
            max-width: 560px;
            margin: 60px auto;
            text-align: center;
        }

        .guest-section h2 {
            font-size: 28px;
            color: var(--gold);
            margin-bottom: 16px;
        }

        .guest-section p {
            color: var(--text-muted);
            line-height: 1.75;
            font-size: 15px;
            margin-bottom: 32px;
        }

        .btn-primary-custom {
            background: var(--gold);
            color: #0f1117;
            border: none;
            padding: 10px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-primary-custom:hover { background: var(--gold-dark); color: #0f1117; }

        .btn-outline-custom {
            background: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
            padding: 10px 28px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-outline-custom:hover {
            background: rgba(201,169,110,0.1);
            color: var(--gold);
        }

        /* ===== Details summary ===== */
        details summary {
            color: var(--gold);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            list-style: none;
            margin-bottom: 8px;
        }

        details summary::before {
            content: '▸ ';
        }

        details[open] summary::before {
            content: '▾ ';
        }

        details p {
            color: var(--text-muted);
            font-size: 13px;
            margin-bottom: 4px;
        }

        details strong {
            color: var(--text-main);
        }

        /* ===== Empty state ===== */
        .empty-state {
            text-align: center;
            padding: 60px 24px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            color: var(--border);
            margin-bottom: 16px;
        }
    </style>
</head>
<body>