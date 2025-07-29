<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puerto Mar - Inicio</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .ship-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .ship-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .ship-image {
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        .ship-details {
            padding: 1.5rem;
        }
        
        .ship-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .ship-info {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .ship-info i {
            width: 20px;
            color: #3498db;
            margin-right: 0.5rem;
        }
        
        .ship-info .label {
            font-weight: 600;
            color: #7f8c8d;
            min-width: 80px;
        }
        
        .ship-info .value {
            color: #2c3e50;
        }
        
        .ship-type-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-left: 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .type-pesquero { background-color: #e8f5e8; color: #27ae60; }
        .type-carguero { background-color: #fff3cd; color: #856404; }
        .type-transporte { background-color: #d1ecf1; color: #0c5460; }
        .type-recreativo { background-color: #f8d7da; color: #721c24; }
        .type-patrullero { background-color: #e2e3e5; color: #383d41; }
        .type-otro { background-color: #f8f9fa; color: #6c757d; }
        
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            color: #3498db;
        }
        
        .loading-spinner {
            text-align: center;
            padding: 2rem;
        }
        
        .no-ships {
            text-align: center;
            padding: 3rem;
            color: #7f8c8d;
        }
        
        .no-ships i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #bdc3c7;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-ship me-2"></i>
                <strong>PUERTO MAR</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="inicio.php"><i class="fas fa-home me-1"></i>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-users me-1"></i>Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="embarcaciones.php"><i class="fas fa-ship me-1"></i>Embarcaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cog me-1"></i>Configuración</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold">
                        <i class="fas fa-ship me-3"></i>
                        Bienvenido a Puerto Mar
                    </h1>
                    <p class="lead">Gestiona tu flota pesquera de manera eficiente y profesional</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-anchor" style="font-size: 4rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="stats-card">
                    <i class="fas fa-ship text-primary mb-2" style="font-size: 2rem;"></i>
                    <div class="stats-number" id="totalEmbarcaciones">-</div>
                    <div class="text-muted">Total Embarcaciones</div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="stats-card">
                    <i class="fas fa-users text-success mb-2" style="font-size: 2rem;"></i>
                    <div class="stats-number" id="totalUsuarios">-</div>
                    <div class="text-muted">Total Usuarios</div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar embarcación...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterType">
                    <option value="">Todos los tipos</option>
                    <option value="Pesquero">Pesquero</option>
                    <option value="Carguero">Carguero</option>
                    <option value="Transporte">Transporte</option>
                    <option value="Recreativo">Recreativo</option>
                    <option value="Patrullero">Patrullero</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" onclick="cargarEmbarcaciones()">
                    <i class="fas fa-sync-alt me-1"></i>
                    Actualizar
                </button>
            </div>
        </div>

        <!-- Contenedor de tarjetas -->
        <div id="shipsContainer">
            <div class="loading-spinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-2">Cargando embarcaciones...</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/inicio.js"></script>
</body>
</html> 
