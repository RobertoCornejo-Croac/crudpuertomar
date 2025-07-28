$(document).ready(function() {
    // Función para cargar embarcaciones
    function cargarEmbarcaciones() {
        $.ajax({
            url: 'embarcaciones/listar.php',
            method: 'GET',
            success: function(response) {
                console.log('Embarcaciones cargadas:', response);
                mostrarEmbarcaciones(response);
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar embarcaciones:', error);
                mostrarError('Error al cargar las embarcaciones: ' + error);
            }
        });
    }
    
    // Función para cargar estadísticas
    function cargarEstadisticas() {
        $.ajax({
            url: 'inicio/estadisticas.php',
            method: 'GET',
            success: function(response) {
                $('#totalEmbarcaciones').text(response.total_embarcaciones);
                $('#totalUsuarios').text(response.total_usuarios);
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar estadísticas:', error);
            }
        });
    }
    
    // Función para mostrar embarcaciones en tarjetas
    function mostrarEmbarcaciones(embarcaciones) {
        const container = $('#shipsContainer');
        
        if (!embarcaciones || embarcaciones.length === 0) {
            container.html(`
                <div class="no-ships">
                    <i class="fas fa-ship"></i>
                    <h4>No hay embarcaciones registradas</h4>
                    <p>Comienza agregando tu primera embarcación</p>
                    <a href="embarcaciones.php" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Agregar Embarcación
                    </a>
                </div>
            `);
            return;
        }
        
        let html = '<div class="row">';
        
        embarcaciones.forEach(function(embarcacion) {
            const capacidad = parseFloat(embarcacion.capacidad_carga);
            const capacidadFormateada = Number.isInteger(capacidad) ? capacidad : capacidad.toFixed(2);
            
            const tipoClass = 'type-' + embarcacion.tipo_barco.toLowerCase();
            const iconClass = obtenerIconoTipo(embarcacion.tipo_barco);
            
            // Determinar qué mostrar en la imagen
            let imageContent = '';
            if (embarcacion.foto) {
                imageContent = `<img src="${embarcacion.foto}" alt="${embarcacion.nombre}" style="width: 100%; height: 100%; object-fit: cover;">`;
            } else {
                imageContent = `<i class="${iconClass}"></i>`;
            }
            
            html += `
                <div class="col-lg-4 col-md-6 mb-4 ship-card-wrapper" data-nombre="${embarcacion.nombre.toLowerCase()}" data-tipo="${embarcacion.tipo_barco}">
                    <div class="card ship-card h-100">
                        <div class="ship-image">
                            ${imageContent}
                        </div>
                        <div class="ship-details">
                            <div class="ship-title">${embarcacion.nombre}</div>
                            <span class="ship-type-badge ${tipoClass}">${embarcacion.tipo_barco}</span>
                            
                            <div class="ship-info">
                                <i class="fas fa-calendar"></i>
                                <span class="label">Año:</span>
                                <span class="value">${embarcacion.ano_construccion}</span>
                            </div>
                            
                            <div class="ship-info">
                                <i class="fas fa-weight-hanging"></i>
                                <span class="label">Capacidad:</span>
                                <span class="value">${capacidadFormateada} ton</span>
                            </div>
                            
                            <div class="ship-info">
                                <i class="fas fa-user"></i>
                                <span class="label">Capitán:</span>
                                <span class="value">${embarcacion.usuario_nombre || 'Sin asignar'}</span>
                            </div>
                            
                            <div class="ship-info">
                                <i class="fas fa-clock"></i>
                                <span class="label">Registrado:</span>
                                <span class="value">${formatearFecha(embarcacion.fecha_creacion)}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        container.html(html);
        
    
        $('.ship-card').on('mouseenter', function() {
            $(this).find('i').addClass('fa-bounce');
        }).on('mouseleave', function() {
            $(this).find('i').removeClass('fa-bounce');
        });
    }
    
    // Función para obtener icono según tipo de barco
    function obtenerIconoTipo(tipo) {
        const iconos = {
            'Pesquero': 'fas fa-fish',
            'Carguero': 'fas fa-box',
            'Transporte': 'fas fa-truck',
            'Recreativo': 'fas fa-umbrella-beach',
            'Patrullero': 'fas fa-shield-alt',
            'Otro': 'fas fa-ship'
        };
        return iconos[tipo] || 'fas fa-ship';
    }
    
    // Función para formatear fecha
    function formatearFecha(fecha) {
        if (!fecha) return 'N/A';
        const fechaObj = new Date(fecha);
        return fechaObj.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }
    
    // Función para filtrar embarcaciones
    function filtrarEmbarcaciones() {
        const busqueda = $('#searchInput').val().toLowerCase();
        const tipoFiltro = $('#filterType').val();
        
        $('.ship-card-wrapper').each(function() {
            const $card = $(this);
            const nombre = $card.data('nombre');
            const tipo = $card.data('tipo');
            
            const coincideBusqueda = nombre.includes(busqueda);
            const coincideTipo = !tipoFiltro || tipo === tipoFiltro;
            
            if (coincideBusqueda && coincideTipo) {
                $card.show();
            } else {
                $card.hide();
            }
        });
    }
    
    // Función para mostrar errores
    function mostrarError(mensaje) {
        $('#shipsContainer').html(`
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                ${mensaje}
            </div>
        `);
    }
    
    // Cargar datos al iniciar
    cargarEmbarcaciones();
    cargarEstadisticas();
    
    // Event listeners para filtros
    $('#searchInput').on('input', filtrarEmbarcaciones);
    $('#filterType').on('change', filtrarEmbarcaciones);
    
    // Hacer la función global para el botón
    window.cargarEmbarcaciones = cargarEmbarcaciones;
    
    // Efectos adicionales
    $('.stats-card').on('mouseenter', function() {
        $(this).find('i').addClass('fa-bounce');
    }).on('mouseleave', function() {
        $(this).find('i').removeClass('fa-bounce');
    });
    
    // Tooltips
    $('[title]').tooltip();
    
    // Sidebar responsive
    $('.navbar-toggler').on('click', function() {
        $('.sidebar').toggleClass('show');
    });
    
    // Cerrar sidebar al hacer clic fuera en móviles
    $(document).on('click', function(e) {
        if ($(window).width() <= 768) {
            if (!$(e.target).closest('.sidebar, .navbar-toggler').length) {
                $('.sidebar').removeClass('show');
            }
        }
    });
}); 