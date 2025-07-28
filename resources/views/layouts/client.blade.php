<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client | @yield('title', 'Tableau de bord')</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #e0f7fa; /* Fond bleu ciel très doux */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #00acc1 !important; /* Bleu ciel foncé */
        }

        .navbar .nav-link,
        .navbar .navbar-brand {
            color: #ffffff !important;
            font-weight: 500;
        }

        .navbar .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }

        main {
            padding-top: 30px;
            padding-bottom: 30px;
        }

        /* Boutons */
        .btn-primary, .btn-success {
            border: none;
        }

        .btn-primary {
            background-color: #00bcd4;
        }

        .btn-success {
            background-color: #0097a7;
        }

        .btn-primary:hover {
            background-color: #00acc1;
        }

        .btn-success:hover {
            background-color: #00838f;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('client.dashboard') }}">
                <i class="fas fa-store"></i> Espace Client
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarClient">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarClient">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('client.dashboard') }}" class="nav-link">
                            <i class="fas fa-arrow-left"></i> Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ Auth::user()->name ?? 'Client' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('client.profil.edit') }}">
                                <i class="fas fa-user-cog me-2"></i> Mon profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts') <!-- Pour les scripts dynamiques des vues -->
</body>
</html>
