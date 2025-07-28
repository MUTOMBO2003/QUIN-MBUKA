<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="QUIN MBUKA - Votre quincaillerie en ligne de confiance">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'QUIN MBUKA')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-tools me-2 text-primary"></i> <span class="fw-bold">QUIN MBUKA</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home me-1"></i> Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('produits.public') }}"><i class="fas fa-box-open me-1"></i> Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('promotions.public') }}"><i class="fas fa-tag me-1"></i> Promotions</a></li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <button class="btn position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPanier">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ session('panier') ? count(session('panier')) : 0 }}
                            </span>
                        </button>
                    </li>

                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Se connecter</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i> S'inscrire</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Tableau de bord</a></li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Se déconnecter</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @php
        $panier = session('panier', []);
    @endphp

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasPanier" aria-labelledby="offcanvasPanierLabel">
        <div class="offcanvas-header bg-primary text-white">
            <h5 class="offcanvas-title" id="offcanvasPanierLabel"><i class="fas fa-shopping-cart me-2"></i>Panier</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if(count($panier) > 0)
                <div id="liste-panier">
                    @foreach($panier as $item)
                        <div class="card mb-3" data-id="{{ $item['id'] }}">
                            <div class="row g-0">
                                <div class="col-4">
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid rounded-start" alt="{{ $item['nom'] }}">
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1">{{ $item['nom'] }}</h6>
                                        <div class="input-group input-group-sm mb-1">
                                            <button class="btn btn-outline-secondary btn-moins" type="button">−</button>
                                            <input type="text" class="form-control text-center quantite-input" value="{{ $item['quantite'] }}" readonly>
                                            <button class="btn btn-outline-secondary btn-plus" type="button">+</button>
                                        </div>
                                        <p class="mb-1">PU : {{ number_format($item['prix'], 0, ',', ' ') }} FC</p>
                                        <p class="mb-1 total-item">Total : {{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} FC</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                <p class="text-end fs-6"><strong>Total :</strong> <span id="total-general">
                    {{ number_format(collect($panier)->sum(fn($p) => $p['prix'] * $p['quantite']), 0, ',', ' ') }} FC
                </span></p>
                <p class="text-end text-success"><strong>Livraison :</strong> Gratuite</p>

                @auth
                    <form action="{{ route('client.paniers.valider') }}" method="POST">
                        @csrf
                        <button class="btn btn-success w-100"><i class="fas fa-check"></i> Commander</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-warning w-100"><i class="fas fa-sign-in-alt"></i> Se connecter pour commander</a>
                @endauth

                <form action="{{ route('client.paniers.clear') }}" method="POST" class="mt-2">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger w-100"><i class="fas fa-trash"></i> Vider</button>
                </form>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Votre panier est vide.
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const panier = @json($panier);
            const totalGeneral = document.getElementById('total-general');

            document.querySelectorAll('.card').forEach(card => {
                const id = card.dataset.id;
                const btnPlus = card.querySelector('.btn-plus');
                const btnMoins = card.querySelector('.btn-moins');
                const quantiteInput = card.querySelector('.quantite-input');
                const totalItem = card.querySelector('.total-item');

                btnPlus?.addEventListener('click', () => {
                    let qte = parseInt(quantiteInput.value);
                    qte++;
                    quantiteInput.value = qte;
                    panier[id].quantite = qte;
                    updateTotal(id, totalItem);
                });

                btnMoins?.addEventListener('click', () => {
                    let qte = parseInt(quantiteInput.value);
                    if (qte > 1) {
                        qte--;
                        quantiteInput.value = qte;
                        panier[id].quantite = qte;
                        updateTotal(id, totalItem);
                    }
                });
            });

            function updateTotal(id, totalItem) {
                const prix = panier[id].prix;
                const qte = panier[id].quantite;
                const total = prix * qte;
                totalItem.textContent = "Total : " + new Intl.NumberFormat('fr-FR').format(total) + " FC";

                let totalGeneralValeur = 0;
                for (const i in panier) {
                    totalGeneralValeur += panier[i].prix * panier[i].quantite;
                }
                totalGeneral.textContent = new Intl.NumberFormat('fr-FR').format(totalGeneralValeur) + " FC";
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
