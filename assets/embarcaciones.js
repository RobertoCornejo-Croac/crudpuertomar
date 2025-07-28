$(document).ready(function() {
    // Inicializar DataTable para embarcaciones
    var tabla = $('#tablaEmbarcaciones').DataTable({
        ajax: {
            url: 'embarcaciones/listar.php',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'ano_construccion' },
            { data: 'tipo_barco' },
            { 
                data: 'capacidad_carga',
                render: function(data) {
                    const capacidad = parseFloat(data);
                    // Solo mostrar decimales si no es un número entero
                    const formatted = Number.isInteger(capacidad) ? capacidad : capacidad.toFixed(2);
                    return formatted + ' ton';
                }
            },
            { 
                data: 'usuario_nombre',
                render: function(data, type, row) {
                    return data || '<span class="text-muted">Sin asignar</span>';
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-info me-1" onclick="editarEmbarcacion(${row.id})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarEmbarcacion(${row.id})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]]
    });

    // Cargar usuarios para los selectores
    function cargarUsuarios() {
        $.ajax({
            url: 'embarcaciones/usuarios.php',
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Sin asignar</option>';
                response.forEach(function(usuario) {
                    options += `<option value="${usuario.id}">${usuario.nombre} ${usuario.apellido} (${usuario.nick})</option>`;
                });
                $('#usuario_id, #editUsuarioId').html(options);
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar usuarios:', error);
            }
        });
    }

    // Cargar usuarios al iniciar
    cargarUsuarios();

    // Función para mostrar alertas
    function mostrarAlerta(mensaje, tipo) {
        const alertContainer = $('#alertContainer');
        const alertId = 'alert-' + Date.now();
        
        const alertHtml = `
            <div id="${alertId}" class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                <i class="fas fa-${tipo === 'success' ? 'check-circle' : tipo === 'danger' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        alertContainer.html(alertHtml);
        
        // Auto-ocultar después de 5 segundos
        setTimeout(() => {
            $(`#${alertId}`).fadeOut();
        }, 5000);
    }

    // Función para limpiar formularios
    function limpiarFormulario(formId) {
        $(`#${formId}`)[0].reset();
        $(`#${formId} .form-control`).removeClass('is-invalid');
        $(`#${formId} .invalid-feedback`).remove();
    }

    // Función para validar formulario
    function validarFormulario(formId) {
        let valido = true;
        const form = $(`#${formId}`);
        
        // Limpiar validaciones anteriores
        form.find('.form-control').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
        
        // Validar campos requeridos
        form.find('[required]').each(function() {
            if (!$(this).val().trim()) {
                $(this).addClass('is-invalid');
                $(this).after('<div class="invalid-feedback">Este campo es requerido.</div>');
                valido = false;
            }
        });
        
        // Validar año de construcción
        const ano = parseInt($('#ano_construccion, #editAnoConstruccion').val());
        if (ano && (ano < 1900 || ano > new Date().getFullYear())) {
            $('#ano_construccion, #editAnoConstruccion').addClass('is-invalid');
            $('#ano_construccion, #editAnoConstruccion').after('<div class="invalid-feedback">Año inválido.</div>');
            valido = false;
        }
        
        // Validar capacidad de carga
        const capacidad = parseFloat($('#capacidad_carga, #editCapacidadCarga').val());
        if (capacidad && capacidad <= 0) {
            $('#capacidad_carga, #editCapacidadCarga').addClass('is-invalid');
            $('#capacidad_carga, #editCapacidadCarga').after('<div class="invalid-feedback">La capacidad debe ser mayor a 0.</div>');
            valido = false;
        }
        
        return valido;
    }

    // Manejar envío del formulario de crear embarcación
    $('#formCrearEmbarcacion').on('submit', function(e) {
        e.preventDefault();
        
        if (!validarFormulario('formCrearEmbarcacion')) {
            return;
        }
        
        const formData = new FormData(this);
        
        $.ajax({
            url: 'embarcaciones/crear.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    mostrarAlerta('Embarcación creada exitosamente.', 'success');
                    $('#modalCrearEmbarcacion').modal('hide');
                    limpiarFormulario('formCrearEmbarcacion');
                    tabla.ajax.reload();
                } else {
                    mostrarAlerta('Error al crear la embarcación: ' + (response.message || 'Error desconocido'), 'danger');
                }
            },
            error: function(xhr, status, error) {
                mostrarAlerta('Error al crear la embarcación: ' + error, 'danger');
            }
        });
    });

    // Manejar envío del formulario de editar embarcación
    $('#formEditarEmbarcacion').on('submit', function(e) {
        e.preventDefault();
        
        if (!validarFormulario('formEditarEmbarcacion')) {
            return;
        }
        
        const formData = new FormData(this);
        
        $.ajax({
            url: 'embarcaciones/editar.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    mostrarAlerta('Embarcación actualizada exitosamente.', 'success');
                    $('#modalEditarEmbarcacion').modal('hide');
                    limpiarFormulario('formEditarEmbarcacion');
                    tabla.ajax.reload();
                } else {
                    mostrarAlerta('Error al actualizar la embarcación: ' + (response.message || 'Error desconocido'), 'danger');
                }
            },
            error: function(xhr, status, error) {
                mostrarAlerta('Error al actualizar la embarcación: ' + error, 'danger');
            }
        });
    });

    // Limpiar formularios al cerrar modales
    $('#modalCrearEmbarcacion').on('hidden.bs.modal', function() {
        limpiarFormulario('formCrearEmbarcacion');
    });

    $('#modalEditarEmbarcacion').on('hidden.bs.modal', function() {
        limpiarFormulario('formEditarEmbarcacion');
    });

    // Función global para editar embarcación
    window.editarEmbarcacion = function(id) {
        $.ajax({
            url: 'embarcaciones/obtener.php',
            method: 'POST',
            data: { id: id },
            success: function(response) {
                if (response.success) {
                    const embarcacion = response.embarcacion;
                    $('#editId').val(embarcacion.id);
                    $('#editNombre').val(embarcacion.nombre);
                    $('#editAnoConstruccion').val(embarcacion.ano_construccion);
                    $('#editTipoBarco').val(embarcacion.tipo_barco);
                    $('#editCapacidadCarga').val(embarcacion.capacidad_carga);
                    $('#editUsuarioId').val(embarcacion.usuario_id || '');
                    
                    // Mostrar foto actual si existe
                    if (embarcacion.foto) {
                        $('#currentFoto').html(`
                            <div class="alert alert-info">
                                <strong>Foto actual:</strong><br>
                                <img src="${embarcacion.foto}" alt="Foto actual" style="max-width: 100px; max-height: 100px; object-fit: cover;" class="mt-2">
                            </div>
                        `);
                    } else {
                        $('#currentFoto').html('<div class="alert alert-warning">No hay foto actual</div>');
                    }
                    
                    $('#modalEditarEmbarcacion').modal('show');
                } else {
                    mostrarAlerta('Error al obtener datos de la embarcación: ' + (response.message || 'Error desconocido'), 'danger');
                }
            },
            error: function(xhr, status, error) {
                mostrarAlerta('Error al obtener datos de la embarcación: ' + error, 'danger');
            }
        });
    };

    // Función global para eliminar embarcación
    window.eliminarEmbarcacion = function(id) {
        if (confirm('¿Está seguro de que desea eliminar esta embarcación? Esta acción no se puede deshacer.')) {
            $.ajax({
                url: 'embarcaciones/eliminar.php',
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    if (response.success) {
                        mostrarAlerta('Embarcación eliminada exitosamente.', 'success');
                        tabla.ajax.reload();
                    } else {
                        mostrarAlerta('Error al eliminar la embarcación: ' + (response.message || 'Error desconocido'), 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    mostrarAlerta('Error al eliminar la embarcación: ' + error, 'danger');
                }
            });
        }
    };

    // Efectos visuales adicionales
    $('.btn').on('mouseenter', function() {
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