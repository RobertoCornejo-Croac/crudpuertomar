$(document).ready(function() {
    // Inicializar DataTable
    var tabla = $('#tablaUsuarios').DataTable({
        ajax: {
            url: 'usuarios/listar.php',
            dataSrc: ''
        },
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'apellido' },
            { data: 'nick' },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-info me-1" onclick="editarUsuario(${row.id})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(${row.id})" title="Eliminar">
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
        
        // Validar nick único 
        if (formId === 'formCrearUsuario') {
            const nick = $('#nick').val().trim();
            if (nick) {
                $.ajax({
                    url: 'usuarios/verificar_nick.php',
                    method: 'POST',
                    data: { nick: nick },
                    async: false,
                    success: function(response) {
                        if (response.existe) {
                            $('#nick').addClass('is-invalid');
                            $('#nick').after('<div class="invalid-feedback">Este nick ya está en uso.</div>');
                            valido = false;
                        }
                    }
                });
            }
        }
        
        return valido;
    }

    // Manejar envío del formulario de crear usuario
    $('#formCrearUsuario').on('submit', function(e) {
        e.preventDefault();
        
        if (!validarFormulario('formCrearUsuario')) {
            return;
        }
        
        const formData = {
            nombre: $('#nombre').val().trim(),
            apellido: $('#apellido').val().trim(),
            nick: $('#nick').val().trim(),
            clave: $('#clave').val()
        };
        
        $.ajax({
            url: 'usuarios/crear.php',
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                if (response.success) {
                    mostrarAlerta('Usuario creado exitosamente.', 'success');
                    $('#modalCrearUsuario').modal('hide');
                    limpiarFormulario('formCrearUsuario');
                    tabla.ajax.reload();
                } else {
                    mostrarAlerta('Error al crear el usuario: ' + (response.message || 'Error desconocido'), 'danger');
                }
            },
            error: function(xhr, status, error) {
                mostrarAlerta('Error al crear el usuario: ' + error, 'danger');
            }
        });
    });

    // Manejar envío del formulario de editar usuario
    $('#formEditarUsuario').on('submit', function(e) {
        e.preventDefault();
        
        if (!validarFormulario('formEditarUsuario')) {
            return;
        }
        
        const formData = {
            id: $('#editId').val(),
            nombre: $('#editNombre').val().trim(),
            apellido: $('#editApellido').val().trim(),
            nick: $('#editNick').val().trim(),
            clave: $('#editClave').val()
        };
        
        $.ajax({
            url: 'usuarios/editar.php',
            method: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                if (response.success) {
                    mostrarAlerta('Usuario actualizado exitosamente.', 'success');
                    $('#modalEditarUsuario').modal('hide');
                    limpiarFormulario('formEditarUsuario');
                    tabla.ajax.reload();
                } else {
                    mostrarAlerta('Error al actualizar el usuario: ' + (response.message || 'Error desconocido'), 'danger');
                }
            },
            error: function(xhr, status, error) {
                mostrarAlerta('Error al actualizar el usuario: ' + error, 'danger');
            }
        });
    });

    // Limpiar formularios al cerrar modales
    $('#modalCrearUsuario').on('hidden.bs.modal', function() {
        limpiarFormulario('formCrearUsuario');
    });

    $('#modalEditarUsuario').on('hidden.bs.modal', function() {
        limpiarFormulario('formEditarUsuario');
    });

    // Función global para editar usuario
    window.editarUsuario = function(id) {
        $.ajax({
            url: 'usuarios/obtener.php',
            method: 'POST',
            data: { id: id },
            success: function(response) {
                if (response.success) {
                    const usuario = response.usuario;
                    $('#editId').val(usuario.id);
                    $('#editNombre').val(usuario.nombre);
                    $('#editApellido').val(usuario.apellido);
                    $('#editNick').val(usuario.nick);
                    $('#editClave').val('');
                    $('#modalEditarUsuario').modal('show');
                } else {
                    mostrarAlerta('Error al obtener datos del usuario: ' + (response.message || 'Error desconocido'), 'danger');
                }
            },
            error: function(xhr, status, error) {
                mostrarAlerta('Error al obtener datos del usuario: ' + error, 'danger');
            }
        });
    };

    // Función global para eliminar usuario
    window.eliminarUsuario = function(id) {
        if (confirm('¿Está seguro de que desea eliminar este usuario? Esta acción no se puede deshacer.')) {
            $.ajax({
                url: 'usuarios/eliminar.php',
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    if (response.success) {
                        mostrarAlerta('Usuario eliminado exitosamente.', 'success');
                        tabla.ajax.reload();
                    } else {
                        mostrarAlerta('Error al eliminar el usuario: ' + (response.message || 'Error desconocido'), 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    mostrarAlerta('Error al eliminar el usuario: ' + error, 'danger');
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
