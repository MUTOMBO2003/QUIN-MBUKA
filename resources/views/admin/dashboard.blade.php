@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="admin-dashboard">
    <!-- Header Section -->
    <div class="dashboard-header bg-primary text-white py-4">
        <div class="container">
            <h1 class="mb-3"><i class="fas fa-tachometer-alt me-2"></i> Tableau de bord Administrateur</h1>
        </div>
    </div>

    <!-- Stats Cards -->
<div class="container mt-5">
    <div class="row g-4">
        <!-- Produits Card -->
        <div class="col-md-4">
            <a href="{{ route('admin.produits.index') }}" class="dashboard-card card-hover">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-blue-light">
                        <i class="bi bi-box-seam fs-1 text-primary"></i>
                    </div>
                    <h3 class="card-title mt-3">Produits</h3>
                    <p class="card-text">Gérer les produits en stock</p>
                    <div class="stat-number">{{ $produitsCount ?? 0 }}</div>
                </div>
            </a>
        </div>

        <!-- Catégories Card -->
        <div class="col-md-4">
            <a href="{{ route('admin.categories.index') }}" class="dashboard-card card-hover">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-blue-light">
                        <i class="bi bi-tags fs-1 text-primary"></i>
                    </div>
                    <h3 class="card-title mt-3">Catégories</h3>
                    <p class="card-text">Gérer les catégories</p>
                    <div class="stat-number">{{ $categoriesCount ?? 0 }}</div>
                </div>
            </a>
        </div>

        <!-- Commandes Card -->
        <div class="col-md-4">
            <a href="{{ route('admin.commandes.index') }}" class="dashboard-card card-hover">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-blue-light">
                        <i class="bi bi-cart3 fs-1 text-primary"></i>
                    </div>
                    <h3 class="card-title mt-3">Commandes</h3>
                    <p class="card-text">Suivre les commandes</p>
                    <div class="stat-number">{{ $commandesCount ?? 0 }}</div>
                </div>
            </a>
        </div>

        <!-- Promotions Card -->
        <div class="col-md-4">
            <a href="{{ route('admin.promotions.index') }}" class="dashboard-card card-hover">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-blue-light">
                        <i class="bi bi-percent fs-1 text-primary"></i>
                    </div>
                    <h3 class="card-title mt-3">Promotions</h3>
                    <p class="card-text">Gérer les promotions</p>
                    <div class="stat-number">{{ $promotionsCount ?? 0 }}</div>
                </div>
            </a>
        </div>

        <!-- Utilisateurs Card -->
        <div class="col-md-4">
            <a href="{{ route('admin.utilisateurs.index') }}" class="dashboard-card card-hover">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-blue-light">
                        <i class="bi bi-people fs-1 text-primary"></i>
                    </div>
                    <h3 class="card-title mt-3">Utilisateurs</h3>
                    <p class="card-text">Gérer les comptes</p>
                    <div class="stat-number">{{ $usersCount ?? 0 }}</div>
                </div>
            </a>
        </div>

        <!-- Paiements Card -->
        <div class="col-md-4">
            <a href="{{ route('admin.paiements.index') }}" class="dashboard-card card-hover">
                <div class="card-body text-center">
                    <div class="icon-wrapper bg-blue-light">
                        <i class="bi bi-credit-card-2-front fs-1 text-primary"></i>
                    </div>
                    <h3 class="card-title mt-3">Paiements</h3>
                    <p class="card-text">Suivre les transactions</p>
                    <div class="stat-number">{{ $paiementsCount ?? 0 }}</div>
                </div>
            </a>
        </div>
    </div>
</div>


   <!-- Recent Activity Section -->
<div class="container mt-5 mb-5">
    <div class="recent-activity">
        <h3 class="section-title mb-4"><i class="fas fa-history me-2"></i> Activité récente</h3>
        <div class="activity-list">
            @foreach($recentActivities as $activity)
                @php
                    $type = $activity['type'] ?? 'info';
                    $description = $activity['description'] ?? 'Aucune description';
                    $createdAt = \Carbon\Carbon::parse($activity['created_at'] ?? now());
                @endphp

                <div class="activity-item d-flex mb-3">
                    <div class="activity-icon me-3">
                        @switch($type)
                            @case('commande')
                                <i class="fas fa-shopping-cart text-primary"></i>
                                @break
                            @case('produit')
                                <i class="fas fa-box-open text-success"></i>
                                @break
                            @case('utilisateur')
                                <i class="fas fa-user text-info"></i>
                                @break
                            @default
                                <i class="fas fa-info-circle text-secondary"></i>
                        @endswitch
                    </div>
                    <div class="activity-content">
                        <p class="mb-1">{{ $description }}</p>
                        <small class="text-muted">{{ $createdAt->diffForHumans() }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<style>
    :root {
        --primary-color: #3498db;
        --primary-light: #e8f4fc;
        --primary-dark: #2980b9;
        --white: #ffffff;
        --light-gray: #f8f9fa;
        --dark-gray: #343a40;
    }

    .admin-dashboard {
        background-color: var(--light-gray);
        min-height: 100vh;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .dashboard-header h1 {
        font-weight: 600;
    }

    .search-bar .form-control {
        border-radius: 20px;
        padding: 10px 20px;
        border: none;
    }

    .search-bar .btn {
        border-radius: 0 20px 20px 0;
        padding: 10px 20px;
    }

    .dashboard-card {
        background: var(--white);
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--dark-gray);
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .icon-wrapper {
        width: 60px;
        height: 60px;
        margin: 0 auto;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-blue-light {
        background-color: var(--primary-light);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-top: 10px;
    }

    .card-hover:hover .icon-wrapper {
        background-color: var(--primary-color);
    }

    .card-hover:hover .icon-wrapper i {
        color: white !important;
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 600;
        border-bottom: 2px solid var(--primary-light);
        padding-bottom: 10px;
    }

    .recent-activity {
        background: var(--white);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .dashboard-header h1 {
            font-size: 1.5rem;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
    }
</style>
@endsection