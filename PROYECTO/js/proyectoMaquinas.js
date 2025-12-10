//actualizar una maquina
async function enviarFormularioUpdateMaquina() {
    //const form = document.querySelector('form');
    const form = document.getElementById('actualizar');
    const formData = new FormData(form);
    let res = await fetch('backend/api/updateEquipo.php', {
        method: 'POST',
        body: formData
    });
    let respuesta = await res.json();

    if (res.ok) {
        alert(respuesta.message + " Por favor, recarga la lista de equipos para ver los cambios.");
    } else {
        alert("Error en la solicitud: " + respuesta.message);
    }
}


//crear una nueva maquina
async function enviarFormularioCreateMaquina() {

    const form = document.getElementById('actualizar');
    const formData = new FormData(form);

    let res = await fetch('backend/api/createEquipos.php', {
        method: 'POST',
        body: formData
    });

    let respuesta = await res.json();

    if (res.ok) {
        alert(respuesta.message);
    } else {
        alert("Error en la solicitud: " + respuesta.message);
    }

}

/**
 * Función para obtener y mostrar todos los equipos en la tabla.
 */
async function listAllEquipos() {
    const tableBody = document.querySelector('.table-sm tbody');
    // Limpiar el contenido anterior de la tabla
    tableBody.innerHTML = ''; 

    try {
        const url = 'backend/api/listAllEquipos.php';
        const res = await fetch(url);

        if (!res.ok) {
            throw new Error(`Error HTTP: ${res.status}`);
        }

        const equipos = await res.json();
        //alert(JSON.stringify(equipos)); 
        // Verificar si la respuesta es un array y tiene datos
        if (Array.isArray(equipos) && equipos.length > 0) {
            equipos.forEach((equipo, index) => {
                const row = document.createElement('tr');
                row.className = 'text-center';
                
                // Mapeo seguro de las propiedades del objeto a las celdas de la tabla
                row.innerHTML = `
                    <td>${equipo.ID_EQUIPO}</td>
                    <td>${equipo.DESCRIPCION || 'N/A'}</td>
                    <td>${equipo.UBICACION || 'N/A'}</td>
                    <td>${equipo.MARCA || 'N/A'}</td>
                    <td>${equipo.MODELO || 'N/A'}</td>
                    <td>${equipo.ANO_FABRICACION || 'N/A'}</td>
                    <td>${equipo.HORAS_MAQUINA || 'N/A'}</td>
                    <td>
                        <button type="button" class="btn btn-success" 
                                onclick="mostrarFormActualiza(${equipo.ID_EQUIPO}, '${equipo.DESCRIPCION}', '${equipo.UBICACION}', '${equipo.MARCA}', '${equipo.MODELO}', '${equipo.ANO_FABRICACION}', '${equipo.HORAS_MAQUINA}')">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning" 
                                onclick="confirmDeleteEquipo(${equipo.ID_EQUIPO})">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } else {
            tableBody.innerHTML = '<tr class="text-center"><td colspan="9">No hay equipos registrados.</td></tr>';
        }

    } catch (error) {
        console.error('Error al listar equipos:', error);
        tableBody.innerHTML = '<tr class="text-center"><td colspan="9">Error al cargar los datos: ' + error.message + '</td></tr>';     
    }
}


//ELIMINAR LOS EQUIPOS
function confirmDeleteEquipo(equipoId) {
    deleteEquipo(equipoId);
}

/**
 * Llama a la API para eliminar el equipo y actualiza la tabla.
 * @param {number} equipoId - El ID del equipo a eliminar.
 */
async function deleteEquipo(equipoId) {
    alert("Eliminar equipo con ID: " + equipoId); // Para depuración
    try {
        const url = 'backend/api/deleteEquipo.php';
        // Usamos FormData para enviar el ID como si fuera un formulario POST
        const formData = new FormData();
        formData.append('id_equipo', equipoId);

        const res = await fetch(url, {
            method: 'POST',
            body: formData
        });
        
        const respuesta = await res.json();

        if (res.ok) {
            Swal.fire('¡Eliminado!', respuesta.message || 'El equipo ha sido eliminado.', 'success');
            // Recargar la lista después de la eliminación exitosa
            listAllEquipos(); 
        } else {
            // Error del servidor (ej. 500)
            const errorMessage = respuesta.message || 'Error desconocido al eliminar.';
            Swal.fire('Error', errorMessage, 'error');
        }

    } catch (error) {
        console.error('Error en la eliminación:', error);
        Swal.fire('Error de Conexión', 'No se pudo completar la solicitud de eliminación.', 'error');
    }
}

/**
 * actualiza el equipo con los datos del formulario
 */

function mostrarFormActualiza(id_equipo, descripcion, ubicacion, marca, modelo, ano_fabricacion, horas_maquina) {
    //alert("Mostrar formulario para actualizar el equipo con ID: " + id_equipo);
    // Aquí puedes implementar la lógica para mostrar el formulario de actualización
    document.getElementsByName('id_equipo')[0].value = id_equipo;
    document.getElementsByName('descripcion')[0].value = descripcion;
    document.getElementsByName('ubicacion')[0].value = ubicacion;
    document.getElementsByName('marca')[0].value = marca;
    document.getElementsByName('modelo')[0].value = modelo;
    document.getElementsByName('ano_fabricacion')[0].value = ano_fabricacion;
    document.getElementsByName('horas_maquina')[0].value = horas_maquina;
}