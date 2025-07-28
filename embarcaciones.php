<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puerto Mar - Gestión de Embarcaciones</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">
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
                        <a class="nav-link" href="inicio.php"><i class="fas fa-home me-1"></i>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-users me-1"></i>Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="embarcaciones.php"><i class="fas fa-ship me-1"></i>Embarcaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cog me-1"></i>Configuración</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="fas fa-users me-2"></i>
                                Gestión de Usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="embarcaciones.php">
                                <i class="fas fa-ship me-2"></i>
                                Embarcaciones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-fish me-2"></i>
                                Pesca
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-line me-2"></i>
                                Estadísticas
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-ship text-primary me-2"></i>
                        Gestión de Embarcaciones
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearEmbarcacion">
                            <i class="fas fa-plus me-1"></i>
                            Nueva Embarcación
                        </button>
                    </div>
                </div>

                <!-- Alertas -->
                <div id="alertContainer"></div>

                <!-- Tabla de embarcaciones -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-table text-primary me-2"></i>
                            Listado de Embarcaciones
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablaEmbarcaciones" class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Año</th>
                                        <th>Tipo</th>
                                        <th>Capacidad (ton)</th>
                                        <th>Usuario Asignado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Crear Embarcación -->
    <div class="modal fade" id="modalCrearEmbarcacion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-ship me-2"></i>
                        Crear Nueva Embarcación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCrearEmbarcacion">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre de la Embarcación *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ano_construccion" class="form-label">Año de Construcción *</label>
                                <input type="number" class="form-control" id="ano_construccion" name="ano_construccion" min="1900" max="2024" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipo_barco" class="form-label">Tipo de Barco *</label>
                                <select class="form-control" id="tipo_barco" name="tipo_barco" required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="Pesquero">Pesquero</option>
                                    <option value="Carguero">Carguero</option>
                                    <option value="Transporte">Transporte</option>
                                    <option value="Recreativo">Recreativo</option>
                                    <option value="Patrullero">Patrullero</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="capacidad_carga" class="form-label">Capacidad de Carga (ton) *</label>
                                <input type="number" class="form-control" id="capacidad_carga" name="capacidad_carga" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="usuario_id" class="form-label">Usuario Asignado</label>
                                <select class="form-control" id="usuario_id" name="usuario_id">
                                    <option value="">Sin asignar</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="foto" class="form-label">Foto de la Embarcación</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Embarcación -->
    <div class="modal fade" id="modalEditarEmbarcacion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>
                        Editar Embarcación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditarEmbarcacion">
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editNombre" class="form-label">Nombre de la Embarcación *</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editAnoConstruccion" class="form-label">Año de Construcción *</label>
                                <input type="number" class="form-control" id="editAnoConstruccion" name="ano_construccion" min="1900" max="2024" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editTipoBarco" class="form-label">Tipo de Barco *</label>
                                <select class="form-control" id="editTipoBarco" name="tipo_barco" required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="Pesquero">Pesquero</option>
                                    <option value="Carguero">Carguero</option>
                                    <option value="Transporte">Transporte</option>
                                    <option value="Recreativo">Recreativo</option>
                                    <option value="Patrullero">Patrullero</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editCapacidadCarga" class="form-label">Capacidad de Carga (ton) *</label>
                                <input type="number" class="form-control" id="editCapacidadCarga" name="capacidad_carga" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editUsuarioId" class="form-label">Usuario Asignado</label>
                                <select class="form-control" id="editUsuarioId" name="usuario_id">
                                    <option value="">Sin asignar</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editFoto" class="form-label">Foto de la Embarcación</label>
                                <input type="file" class="form-control" id="editFoto" name="foto" accept="image/*">
                                <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB</small>
                                <div id="currentFoto" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save me-1"></i>
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/embarcaciones.js"></script>
</body>
</html> 