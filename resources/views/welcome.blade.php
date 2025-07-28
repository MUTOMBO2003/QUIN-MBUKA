@extends('layouts.app')

@section('title', 'Bienvenue')

@section('content')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

<div class="welcome-container">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Bienvenue chez <span>QUIN MBUKA</span></h1>
            <p class="hero-subtitle">Votre Quincaillerie en ligne de confiance</p>

            <!-- Search Bar -->
            <form action="{{ route('recherche.produits') }}" method="GET" class="search-form">
                <div class="search-input-group">
                    <input type="text" name="query" class="search-input" placeholder="Rechercher un article ou une catégorie...">
                    <select name="categorie" class="category-select">
                        <option value="">Toutes catégories</option>
                        @foreach(App\Models\Categorie::all() as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Categories Section -->


    <!-- New Arrivals Section -->
    <section class="products-section new-arrivals">
        <div class="section-header">
            <h2 class="section-title">Nouveaux Articles</h2>
            <a href="{{ route('produits.public') }}">Voir tous les produits</a>


        </div>
        <div class="products-grid">
            @foreach($nouveautes as $produit)
            <div class="product-card">
                @if($produit->image)
                <div class="product-image">
                    <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" loading="lazy">
                </div>
                @else
                <div class="product-image no-image">
                    <i class="fas fa-box-open"></i>
                </div>
                @endif
                <div class="product-details">
                    <h3 class="product-name">{{ $produit->nom }}</h3>
                    <p class="product-price">{{ $produit->prix_format }}</p>
                    <form action="{{ route('client.paniers.add', $produit) }}" method="POST">
                        @csrf
                        <button class="add-to-cart-btn">
                            <i class="fas fa-cart-plus"></i> Ajouter
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Promotions Section -->
    <section class="products-section promotions">
        <div class="section-header">
            <h2 class="section-title">Promotions</h2>
            <a href="{{ route('promotions.public') }}">Voir toutes les promotions</a>
        </div>
        <div class="products-grid">
            @foreach($promotions as $produit)
            <div class="product-card promo-card">
                <div class="promo-badge">-{{ calculateDiscountPercentage($produit->prix_initial, $produit->prix) }}%</div>
                @if($produit->image)
                <div class="product-image">
                    <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" loading="lazy">
                </div>
                @else
                <div class="product-image no-image">
                    <i class="fas fa-box-open"></i>
                </div>
                @endif
                <div class="product-details">
                    <h3 class="product-name">{{ $produit->nom }}</h3>
                    <div class="price-container">
                        <span class="old-price">{{ number_format($produit->prix_initial, 0, ',', ' ') }} FC</span>
                        <span class="current-price">{{ $produit->prix_format }}</span>
                    </div>
                    <form action="{{ route('client.paniers.add', $produit) }}" method="POST">
                        @csrf
                        <button class="add-to-cart-btn promo-cart-btn">
                            <i class="fas fa-cart-plus"></i> Ajouter
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="feature-card">
            <i class="fas fa-shipping-fast"></i>
            <h3>Livraison Rapide</h3>
            <p>Livraison dans toute la ville sous 24h</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-undo-alt"></i>
            <h3>Retour Facile</h3>
            <p>30 jours pour retourner vos articles</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-headset"></i>
            <h3>Support 24/7</h3>
            <p>Assistance clientèle toujours disponible</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-lock"></i>
            <h3>Paiement Sécurisé</h3>
            <p>Transactions 100% sécurisées</p>
        </div>
    </section>
</div>

<!-- Footer Section -->
<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-column about-column">
                <h3 class="footer-title">QUIN MBUKA</h3>
                <p class="footer-about">Votre quincaillerie en ligne de confiance, offrant des produits de qualité pour tous vos besoins en construction et rénovation.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-column">
                <h3 class="footer-title">Liens Utiles</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <a href="{{ route('produits.public') }}">Produits</a>
                    <li><a href="{{ route('promotions.public') }}">Promotions</a></li>
                    <li><a href="{{ route('about') }}">À propos</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3 class="footer-title">Catégories</h3>
                <ul class="footer-links">
                    @foreach(['Tuyau', 'Coude', 'Robinet', 'Gyproc', 'Clou'] as $category)
                    <li><a href="{{ route('client.produits.index', ['categorie' => $category]) }}">{{ $category }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="footer-column contact-column">
                <h3 class="footer-title">Contactez-nous</h3>
                <ul class="footer-contact-info">
                    <li><i class="fas fa-map-marker-alt"></i> 537, Avenue Kapenda, C/ Lubumbashi, Ville de Lubumbashi, Haut-Katanga- RD Congo</li>
                    <li><i class="fas fa-phone"></i> +243 972766670 </li>
                    <li><i class="fas fa-envelope"></i> Quinmbuka@gmail.com</li>
                    <li><i class="fas fa-clock"></i> Lundi - Samedi: 8h00 - 17h00</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="copyright">
                &copy; {{ date('Y') }} QUIN MBUKA. Tous droits réservés.
            </div>
            <div class="footer-legal">
                <a href="{{ route('privacy') }}">Confidentialité</a>
                <a href="{{ route('terms') }}">Conditions</a>
                <a href="{{ route('sitemap') }}">Plan du site</a>
            </div>
        </div>
    </div>
</footer>
@endsection

@php
function calculateDiscountPercentage($originalPrice, $discountedPrice) {
if ($originalPrice <= 0) return 0;
    return round((($originalPrice - $discountedPrice) / $originalPrice) * 100);
    }
    @endphp