@extends('layouts.client')

@section('title', 'Mon panier')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-shopping-cart"></i> Mon panier</h2>
        <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPanier">
            <i class="fas fa-eye"></i> Voir en aperçu latéral
        </button>
    </div>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    @php
        $panier = session('panier', []);
    @endphp

    @if(count($panier) > 0)
        <div class="row mt-4" id="panier-container">
            @foreach($panier as $item)
                <div class="col-md-4 mb-4" data-id="{{ $item['id'] }}">
                    <div class="card h-100">
                        @if(!empty($item['image']))
                            <img src="{{ asset('storage/' . $item['image']) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=Produit" class="card-img-top">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item['nom'] }}</h5>
                            <div class="input-group input-group-sm mb-2">
                                <button class="btn btn-outline-secondary btn-moins" type="button">−</button>
                                <input type="text" class="form-control text-center quantite-input" value="{{ $item['quantite'] }}" readonly>
                                <button class="btn btn-outline-secondary btn-plus" type="button">+</button>
                            </div>
                            <p>PU : <strong>{{ number_format($item['prix'], 0, ',', ' ') }} FC</strong></p>
                            <p class="total-item">Total : <strong>{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} FC</strong></p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <form action="{{ route('client.paniers.remove', $item['id']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger w-100">
                                    <i class="fas fa-trash-alt"></i> Retirer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="alert alert-secondary text-end fs-5 mt-3">
            <strong>Total général :</strong> <span id="total-general">
                {{ number_format(collect($panier)->sum(fn($p) => $p['prix'] * $p['quantite']), 0, ',', ' ') }} FC
            </span><br>
            <span class="text-success"><strong>Livraison : Gratuite</strong></span>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <form action="{{ route('client.paniers.clear') }}" method="POST">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger">
                    <i class="fas fa-times"></i> Vider le panier
                </button>
            </form>

            @auth
                <form action="{{ route('client.paniers.valider') }}" method="POST">
                    @csrf
                    <button class="btn btn-success">
                        <i class="fas fa-check-circle"></i> Valider la commande
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-warning">
                    <i class="fas fa-sign-in-alt"></i> Se connecter pour commander
                </a>
            @endauth
        </div>
    @else
        <div class="alert alert-info text-center mt-4">
            <i class="fas fa-info-circle me-2"></i> Votre panier est vide pour le moment.
        </div>
    @endif
</div>

<!-- Offcanvas Panier -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasPanier" aria-labelledby="offcanvasPanierLabel">
    <div class="offcanvas-header bg-primary text-white">
        <h5 class="offcanvas-title" id="offcanvasPanierLabel"><i class="fas fa-shopping-cart me-2"></i>Aperçu panier</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        @if(count($panier) > 0)
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

            <hr>
            <p class="text-end"><strong>Total : </strong><span id="offcanvas-total">
                {{ number_format(collect($panier)->sum(fn($p) => $p['prix'] * $p['quantite']), 0, ',', ' ') }} FC
            </span></p>
            <p class="text-end text-success"><strong>Livraison : </strong>Gratuite</p>

            @auth
                <form action="{{ route('client.paniers.valider') }}" method="POST">
                    @csrf
                    <button class="btn btn-success w-100"><i class="fas fa-check"></i> Commander</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-warning w-100"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
            @endauth

            <form action="{{ route('client.paniers.clear') }}" method="POST" class="mt-2">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger w-100"><i class="fas fa-times"></i> Vider le panier</button>
            </form>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Votre panier est vide.
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const panier = @json($panier);
        const totalGeneral = document.getElementById('total-general');
        const offcanvasTotal = document.getElementById('offcanvas-total');

        document.querySelectorAll('[data-id]').forEach(card => {
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

            let totalG = 0;
            for (const i in panier) {
                totalG += panier[i].prix * panier[i].quantite;
            }

            if (totalGeneral) {
                totalGeneral.textContent = new Intl.NumberFormat('fr-FR').format(totalG) + " FC";
            }
            if (offcanvasTotal) {
                offcanvasTotal.textContent = new Intl.NumberFormat('fr-FR').format(totalG) + " FC";
            }
        }
    });
</script>
@endpush
