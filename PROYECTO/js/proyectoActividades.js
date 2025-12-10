//actualizar una actividad de una maquina
async function enviarFormularioUpdateActividad() {
    const form = document.getElementById('formActualizarActividad');
    const formData = new FormData(form);
    let res = await fetch('backend/api/updateActividad.php', {
        method: 'POST',
        body: formData
    });
    let respuesta = await res.json();
    if (res.ok) {
        alert(respuesta.message + " Por favor, recarga la lista de actividades para ver los cambios.");
    } else {
        alert("Error en la solicitud: " + respuesta.message);
    }
}


//crear una nueva maquina
async function enviarFormularioCreateActividad() {

    const form = document.querySelector('form');
    const formData = new FormData(form);

    let res = await fetch('backend/api/createActividades.php', {
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


async function listAllActividadesByEquipo() {
    const tableBody = document.querySelector('.table-sm tbody');
    let id_equipo = document.getElementsByName('id_equipo')[0].value;

    //parametro id_equipo de la url
    const urlParams = new URLSearchParams(window.location.search);
    id_equipo = urlParams.get('id_equipo');
    //alert("ID del equipo: " + id_equipo); // Para depuración
    tableBody.innerHTML = ''; 

    try {
        const url = 'backend/api/listActividadesEquipoById.php';
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ "id_equipo": id_equipo })
        });

        if (!res.ok) {
            throw new Error(`Error HTTP: ${res.status}`);
        }

        const actividades = await res.json();
        console.log(JSON.stringify(actividades)); 
        // Verificar si la respuesta es un array y tiene datos
        if (Array.isArray(actividades) && actividades.length > 0) {
            actividades.forEach((actividad, index) => {
                const row = document.createElement('tr');
                row.className = 'text-center';
                
                // Mapeo seguro de las propiedades del objeto a las celdas de la tabla
                row.innerHTML = `
                    <td>${actividad.ID_TAREA}</td>
                    <td>${actividad.ID_EQUIPO}</td>
                    <td>${actividad.TAREA}</td>
                    <td>${actividad.INTERVALO_HORAS_MAQUINA}</td>
                    <td>${actividad.FECHA_ULT_MANT }</td>
                    <td>${actividad.CANT_HORAS}</td>
                    <td>${actividad.HORAS_SIG_MANTENIMIENTO}</td>
                    <td>${actividad.FECHA_SIG_MANTENIMIENTO}</td>
                    <td>${actividad.ULTIMO_TECNICO}</td>
                    <td>${actividad.SIG_TECNICO_ASIGN}</td>
                    <td>
                        <button type="button" class="btn btn-success" 
                                onclick="mostrarFormActualiza(${actividad.ID_TAREA}, 
                                '${actividad.ID_EQUIPO}', 
                                '${actividad.TAREA}', 
                                '${actividad.INTERVALO_HORAS_MAQUINA}', 
                                '${actividad.FECHA_ULT_MANT}', 
                                '${actividad.CANT_HORAS}', 
                                '${actividad.HORAS_SIG_MANTENIMIENTO}', 
                                '${actividad.FECHA_SIG_MANTENIMIENTO}', 
                                '${actividad.ULTIMO_TECNICO}',
                                '${actividad.SIG_TECNICO_ASIGN}')">
                                
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning" 
                                onclick="confirmDeleteActividad(${actividad.ID_TAREA})">
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
        tableBody.innerHTML = `<tr class="text-center"><td colspan="9">Error al cargar los datos: ${error.message}</td></tr>`;     
    }
}


//ELIMINAR LOS EQUIPOS
function confirmDeleteActividad(id_tarea) {
    deleteActividad(id_tarea);
}


async function deleteActividad(id_tarea) {
    //alert("Eliminar equipo con ID: " + equipoId); // Para depuración
    try {
        const url = 'backend/api/deleteActividad.php'; 
        // Usamos FormData para enviar el ID como si fuera un formulario POST
        const formData = new FormData();
        formData.append('id_actividad', id_tarea);
        const res = await fetch(url, {
            method: 'POST',
            body: formData
        });
        
        const respuesta = await res.json();

        if (res.ok) {
            Swal.fire('¡Eliminado!', respuesta.message || 'La actividad ha sido eliminada.', 'success');
            // Recargar la lista después de la eliminación exitosa
            listAllActividades(); 
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

function mostrarFormActualiza(id_tarea, id_equipo, tarea, intervalo_horas_maquina, fecha_ult_mant, cant_horas, horas_sig_mant, fecha_sig_mant, ult_tecnico_asig, sig_tecnico_asign) {
    document.getElementById('id_tarea').value = id_tarea;
    document.getElementById('id_equipo').value = id_equipo;
    document.getElementById('tarea').value = tarea;
    document.getElementById('intervalo_horas_maquina').value = intervalo_horas_maquina;
    document.getElementById('fecha_ult_mant').value = fecha_ult_mant;
    document.getElementById('cant_horas').value = cant_horas;
    document.getElementById('horas_sig_mant').value = horas_sig_mant;
    document.getElementById('fecha_sig_mant').value = fecha_sig_mant;
    document.getElementById('ult_tecnico_asig').value = ult_tecnico_asig;
    document.getElementById('sig_tecnico_asign').value = sig_tecnico_asign;
}

//lista todas las actividades
async function listAllActividades() {
    const tableBody = document.querySelector('.table-sm tbody');
    tableBody.innerHTML = '';
    try {
        const res = await fetch('backend/api/listAllActividades.php');  
        if (!res.ok) {
            throw new Error(`Error HTTP: ${res.status}`);
        }
        const actividades = await res.json();
        actividades.forEach((actividad, index) => {
            const row = document.createElement('tr');   
            row.className = 'text-center';
            row.innerHTML = `
                <td>${actividad.ID_TAREA}</td>
                <td>${actividad.ID_EQUIPO}</td>
                <td>${actividad.TAREA}</td>
                <td>${actividad.INTERVALO_HORAS_MAQUINA}</td>
                <td>${actividad.FECHA_ULT_MANT }</td>
                <td>${actividad.CANT_HORAS}</td>
                <td>${actividad.HORAS_SIG_MANTENIMIENTO}</td>
                <td>${actividad.FECHA_SIG_MANTENIMIENTO}</td>
                <td>${actividad.ULTIMO_TECNICO}</td>
                <td>${actividad.SIG_TECNICO_ASIGN}</td><td>
                        <button type="button" class="btn btn-success" 
                                onclick="mostrarFormActualiza(${actividad.ID_TAREA}, 
                                '${actividad.ID_EQUIPO}', 
                                '${actividad.TAREA}', 
                                '${actividad.INTERVALO_HORAS_MAQUINA}', 
                                '${actividad.FECHA_ULT_MANT}', 
                                '${actividad.CANT_HORAS}', 
                                '${actividad.HORAS_SIG_MANTENIMIENTO}', 
                                '${actividad.FECHA_SIG_MANTENIMIENTO}', 
                                '${actividad.ULTIMO_TECNICO}',
                                '${actividad.SIG_TECNICO_ASIGN}')">
                                
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning" 
                                onclick="confirmDeleteActividad(${actividad.ID_TAREA})">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </td>
            `;
            tableBody.appendChild(row);
        });
    } catch (error) {
        tableBody.innerHTML = `<tr class="text-center"><td colspan="9">Error al cargar los datos: ${error.message}</td></tr>`;     
    }   
}

async function viewMantenimientosProgramados() {
    try {
        const res = await fetch('backend/api/viewMantenimientosProgramados.php');  
        if (!res.ok) {
            throw new Error(`Error HTTP: ${res.status}`);
        }
        const mantenimientos = await res.json();
        console.log(mantenimientos);
// llena la tabla con los mantenimientos programados
        const tableBody = document.querySelector('.table-sm tbody');
        tableBody.innerHTML = '';
        mantenimientos.forEach((mantenimiento) => {
            const row = document.createElement('tr');   
            row.className = 'text-center';
            row.innerHTML = `
                <td>${mantenimiento.ID_TAREA}</td>
                <td>${mantenimiento.ID_EQUIPO}</td>
                <td>${mantenimiento.TAREA}</td>
                <td>${mantenimiento.INTERVALO_HORAS_MAQUINA}</td>
                <td>${mantenimiento.CANT_HORAS}</td>
                <td>${mantenimiento.HORAS_RESTANTES_MANTENIMIENTO}</td>
            `;
            tableBody.appendChild(row);
        });

    } catch (error) {
        console.error('Error al cargar los mantenimientos programados:', error);
    }
}