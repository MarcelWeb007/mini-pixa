<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mini-Pixa API - Documentation Interactive</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Google Fonts (Fira Code & Inter) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            :root {
                --fastapi-teal: #059669;
                --fastapi-teal-light: #ecfdf5;
                --fastapi-teal-border: #a7f3d0;
                --fastapi-bg: #f8fafc;
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--fastapi-bg);
                color: #1e293b;
            }

            code, pre, .font-mono {
                font-family: 'Fira Code', monospace;
            }

            /* Navbar styling */
            .navbar-fastapi {
                background-color: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(8px);
                border-bottom: 1px solid #e2e8f0;
            }

            .brand-icon {
                background-color: var(--fastapi-teal);
                color: white;
                width: 38px;
                height: 38px;
                border-radius: 8px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                font-weight: bold;
            }

            /* Method Badges */
            .badge-method {
                font-family: 'Fira Code', monospace;
                font-weight: 700;
                min-width: 65px;
                padding: 6px 10px;
                text-align: center;
                border-radius: 6px;
            }
            .badge-get { background-color: #2563eb; color: #ffffff; }
            .badge-post { background-color: #059669; color: #ffffff; }
            .badge-delete { background-color: #dc2626; color: #ffffff; }
            .badge-purple { background-color: #7c3aed; color: #ffffff; }

            /* Terminal Block */
            .terminal-window {
                background-color: #0f172a;
                border-radius: 12px;
                border: 1px solid #1e293b;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                overflow: hidden;
            }
            .terminal-header {
                background-color: #020617;
                padding: 10px 16px;
                border-bottom: 1px solid #1e293b;
            }
            .terminal-dot {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                display: inline-block;
            }

            /* Custom Cards */
            .card-fastapi {
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                transition: all 0.2s ease-in-out;
            }
            .card-fastapi:hover {
                border-color: #cbd5e1;
                box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            }

            .endpoint-row {
                background-color: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 12px 16px;
                transition: background-color 0.15s ease;
            }
            .endpoint-row:hover {
                background-color: #f1f5f9;
            }

            /* Production Pill */
            .prod-pill {
                background-color: var(--fastapi-teal-light);
                border: 1px solid var(--fastapi-teal-border);
                color: #065f46;
                border-radius: 50rem;
                padding: 6px 18px;
                font-size: 0.875rem;
            }
        </style>
    </head>
    <body class="d-flex flex-column min-vh-100">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg sticky-top navbar-fastapi py-3">
            <div class="container max-width-6xl">
                <a class="navbar-brand d-flex items-center gap-2 fw-bold text-dark" href="#">
                    <span class="brand-icon me-2">⚡</span>
                    <span>Mini-Pixa <span style="color: var(--fastapi-teal);">API</span></span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill ms-2 font-mono" style="font-size: 0.75rem;">v1.0.0</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav gap-3 font-medium text-sm">
                        <li class="nav-item"><a class="nav-link text-secondary" href="#quickstart">Quickstart</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#public-routes">Routes Publiques</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#protected-routes">Routes Protégées</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#advice">Conseils</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Container -->
        <main class="container my-5 flex-grow-1" style="max-width: 960px;">

            <!-- Hero Section -->
            <div class="text-center my-4">
                <div class="d-inline-flex align-items-center gap-2 prod-pill mb-4 font-mono shadow-sm">
                    <span class="spinner-grow spinner-grow-sm text-success" role="status"></span>
                    <span>URL de production :</span>
                    <strong class="text-dark">https://mini-pixa-production-bs4miy.laravel.cloud</strong>
                </div>
                <h1 class="display-4 fw-extrabold text-dark tracking-tight mb-3">
                    Documentation de l'API <span style="color: var(--fastapi-teal);">Mini-Pixa</span>
                </h1>
                <p class="lead text-secondary mx-auto" style="max-width: 680px;">
                    API REST pour la gestion et le partage de photos (Clone Pixabay), propulsée par Laravel & Cloudflare R2 Storage.
                </p>
            </div>

            <!-- Terminal / Code Preview (FastAPI Style) -->
            <div id="quickstart" class="terminal-window my-5">
                <div class="terminal-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="terminal-dot bg-danger"></span>
                        <span class="terminal-dot bg-warning"></span>
                        <span class="terminal-dot bg-success"></span>
                        <span class="text-secondary ms-2 small font-mono">test-api.js — Exemple d'appel JS Vanilla</span>
                    </div>
                    <span class="badge bg-dark text-success border border-secondary font-mono">⚡ GET /api/photos</span>
                </div>
                <div class="p-4 font-mono text-light overflow-x-auto" style="font-size: 0.9rem; line-height: 1.6;">
                    <span style="color: #c678dd;">const</span> <span style="color: #61afef;">BASE_URL</span> = <span style="color: #98c379;">'https://mini-pixa-production-bs4miy.laravel.cloud/api'</span>;<br><br>
                    <span style="color: #5c6370;">// Récupérer toutes les photos</span><br>
                    <span style="color: #c678dd;">const</span> response = <span style="color: #c678dd;">await</span> <span style="color: #61afef;">fetch</span>(<span style="color: #98c379;">`${BASE_URL}/photos`</span>, {<br>
                    &nbsp;&nbsp;headers: { <span style="color: #98c379;">'Accept'</span>: <span style="color: #98c379;">'application/json'</span> }<br>
                    });<br>
                    <span style="color: #c678dd;">const</span> photos = <span style="color: #c678dd;">await</span> response.<span style="color: #61afef;">json</span>();<br>
                    <span style="color: #61afef;">console</span>.<span style="color: #e5c07b;">log</span>(photos);
                </div>
            </div>

            <!-- Cards Conseils (Vanilla JS & Postman) -->
            <div id="advice" class="row g-4 my-4">
                <div class="col-md-6">
                    <div class="card card-fastapi h-100 p-4 shadow-sm">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-warning-subtle text-warning-emphasis font-mono px-2 py-1">JS VANILLA</span>
                            <h5 class="fw-bold mb-0">Recommandé : Javascript Pur</h5>
                        </div>
                        <p class="card-text text-secondary small leading-relaxed">
                            Utilisez <strong>Vanilla JS</strong> avec <code class="bg-light text-success px-2 py-1 rounded font-mono">fetch()</code> et <code class="bg-light text-success px-2 py-1 rounded font-mono">FormData</code> pour consommer l'API et dynamiser le DOM sans dépendances externes.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-fastapi h-100 p-4 shadow-sm">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-orange-subtle text-danger font-mono px-2 py-1" style="background-color: #fff3ed; color: #d97706;">POSTMAN</span>
                            <h5 class="fw-bold mb-0">Recommandé : Postman</h5>
                        </div>
                        <p class="card-text text-secondary small leading-relaxed">
                            Testez vos endpoints sur <strong>Postman</strong> avant de coder. N'oubliez pas d'ajouter le header <code class="bg-light text-danger px-2 py-1 rounded font-mono">Authorization: Bearer &lt;token&gt;</code> pour les routes protégées.
                        </p>
                    </div>
                </div>
            </div>

            <!-- SECTION 1 : ROUTES PUBLIQUES -->
            <div id="public-routes" class="card card-fastapi p-4 shadow-sm my-4">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                    <div>
                        <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                            <span style="color: var(--fastapi-teal);">#</span> Routes Publiques
                        </h4>
                        <p class="text-muted small mb-0">Accessibles à tous les utilisateurs sans authentification.</p>
                    </div>
                    <span class="badge bg-light text-secondary border font-mono">Tout public</span>
                </div>

                <div class="d-flex flex-column gap-3">
                    <!-- GET /categories -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-get">GET</span>
                            <span class="fw-bold font-mono text-dark">/api/categories</span>
                        </div>
                        <span class="text-secondary small">Récupère la liste de toutes les catégories de photos.</span>
                    </div>

                    <!-- GET /photos -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-get">GET</span>
                            <span class="fw-bold font-mono text-dark">/api/photos</span>
                        </div>
                        <span class="text-secondary small">Liste des photos récentes avec auteur, likes et filtre optionnel (<code class="bg-white px-1 border rounded">?category_id=X</code>).</span>
                    </div>

                    <!-- GET /photos/{photo} -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-get">GET</span>
                            <span class="fw-bold font-mono text-dark">/api/photos/{photo}</span>
                        </div>
                        <span class="text-secondary small">Affiche les détails d'une photo spécifique à partir de son ID.</span>
                    </div>

                    <!-- POST /register -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-post">POST</span>
                            <span class="fw-bold font-mono text-dark">/api/register</span>
                        </div>
                        <span class="text-secondary small">Crée un nouveau compte utilisateur (Retourne le token Sanctum).</span>
                    </div>

                    <!-- POST /login -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-post">POST</span>
                            <span class="fw-bold font-mono text-dark">/api/login</span>
                        </div>
                        <span class="text-secondary small">Authentifie l'utilisateur et génère un Bearer Token.</span>
                    </div>
                </div>
            </div>

            <!-- SECTION 2 : ROUTES PROTÉGÉES -->
            <div id="protected-routes" class="card card-fastapi p-4 shadow-sm my-4">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                    <div>
                        <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                            <span>🔒</span> Routes Protégées
                        </h4>
                        <p class="text-muted small mb-0">Nécessite le header : <code class="bg-light text-warning-emphasis px-2 py-0.5 rounded font-mono">Authorization: Bearer &lt;token&gt;</code></p>
                    </div>
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle font-mono">Auth (Sanctum)</span>
                </div>

                <div class="d-flex flex-column gap-3">
                    <!-- POST /logout -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-post">POST</span>
                            <span class="fw-bold font-mono text-dark">/api/logout</span>
                        </div>
                        <span class="text-secondary small">Révoque et supprime le token de l'utilisateur actuellement connecté.</span>
                    </div>

                    <!-- GET /me -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-get">GET</span>
                            <span class="fw-bold font-mono text-dark">/api/me</span>
                        </div>
                        <span class="text-secondary small">Retourne le profil de l'utilisateur connecté.</span>
                    </div>

                    <!-- POST /categories -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-post">POST</span>
                            <span class="fw-bold font-mono text-dark">/api/categories</span>
                        </div>
                        <span class="text-secondary small">Crée une nouvelle catégorie dans l'application.</span>
                    </div>

                    <!-- POST /photos -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-post">POST</span>
                            <span class="fw-bold font-mono text-dark">/api/photos</span>
                        </div>
                        <span class="text-secondary small">Publie/Upload une photo vers Cloudflare R2 (<code class="bg-white px-1 border rounded">multipart/form-data</code>).</span>
                    </div>

                    <!-- DELETE /photos/{photo} -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-delete">DELETE</span>
                            <span class="fw-bold font-mono text-dark">/api/photos/{photo}</span>
                        </div>
                        <span class="text-secondary small">Supprime définitivement une photo appartenant à l'utilisateur connecté.</span>
                    </div>

                    <!-- POST /photos/{photo}/like -->
                    <div class="endpoint-row d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-method badge-purple">POST</span>
                            <span class="fw-bold font-mono text-dark">/api/photos/{photo}/like</span>
                        </div>
                        <span class="text-secondary small">Bascule (Toggle) le statut du like : ajoute le like ou le retire.</span>
                    </div>
                </div>
            </div>

            <!-- Banner Bonne Chance -->
            <div class="p-5 rounded-4 text-center text-white shadow-sm my-5" style="background: linear-gradient(135deg, #059669 0%, #0d9488 100%);">
                <h3 class="fw-bold mb-2">🚀 Bonne chance boas !</h3>
                <p class="mb-0 text-white-50 mx-auto" style="max-width: 600px;">
                    Développez sereinement votre interface avec Vanilla JS. Que toutes vos requêtes API retournent un statut <span class="badge bg-white text-dark font-mono px-2 py-1">200 OK</span> !
                </p>
            </div>

        </main>

        <!-- Footer -->
        <footer class="bg-white border-top py-4 text-center text-muted small">
            <div class="container">
                Mini-Pixa API — Propulsé par Laravel Cloud & ANVANE Marcel
            </div>
        </footer>

        <!-- Bootstrap 5 JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="center"></script>
    </body>
</html>
