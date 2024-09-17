// /js/script.js

// Función para mostrar una sección específica
function mostrarSeccion(seccion) {
    // Ocultar todas las secciones
    document.querySelectorAll('.seccion').forEach((div) => {
        div.style.display = 'none';
    });

    // Mostrar la sección seleccionada
    document.getElementById(seccion).style.display = 'block';

    // Si la sección seleccionada es 'lista-alumnos', obtener la lista de estudiantes
    if (seccion === 'lista-alumnos') {
        obtenerListaEstudiantes();
    }
}

// Función para obtener la lista de estudiantes
function obtenerListaEstudiantes() {
    // Realizar una solicitud fetch al archivo PHP para obtener la lista de estudiantes
    fetch('../ajax/obtener_estudiantes.php')
        .then(response => response.json())  // Convertir la respuesta en JSON
        .then(data => {
            // Si hay un error en los datos, mostrar un mensaje de error
            if(data.error){
                document.getElementById('resultado-lista-alumnos').innerHTML = `<div class="alert">${data.error}</div>`;
                return;
            }
            // Generar el HTML para mostrar la lista de estudiantes en una tabla
            let output = '<table><tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Edad</th><th>Acciones</th></tr>';
            data.forEach(estudiante => {
                output += `<tr>
                             <td>${estudiante.id}</td>
                             <td>${estudiante.nombre}</td>
                             <td>${estudiante.apellido}</td>
                             <td>${estudiante.email}</td>
                             <td>${estudiante.edad}</td>
                             <td>
                                 <button class="edit" onclick="editarEstudiante(${estudiante.id})">Editar</button>
                                 <button class="delete" onclick="eliminarEstudiante(${estudiante.id})">Eliminar</button>
                             </td>
                           </tr>`;
            });
            output += '</table>';
            // Insertar el HTML generado en el contenedor adecuado
            document.getElementById('resultado-lista-alumnos').innerHTML = output;
        })
        .catch(error => {
            // Manejo de errores en caso de que la solicitud falle
            console.error('Error:', error);
            document.getElementById('resultado-lista-alumnos').innerHTML = `<div class="alert">Error al obtener la lista de alumnos.</div>`;
        });
}

// Función para crear un nuevo estudiante
document.getElementById('form-crear-alumno').addEventListener('submit', function(e) {
    e.preventDefault();

    // Obtener los valores de los campos del formulario
    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const email = document.getElementById('email').value;
    const edad = document.getElementById('edad').value;

    // Enviar los datos del nuevo estudiante al servidor usando fetch
    fetch('../ajax/crear_alumno.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ nombre, apellido, email, edad })
    })
    .then(response => response.json())  // Convertir la respuesta en JSON
    .then(data => {
        // Mostrar un mensaje de éxito o error
        alert(data.message);
        obtenerListaEstudiantes(); // Actualizar la lista de estudiantes
        document.getElementById('form-crear-alumno').reset(); // Limpiar el formulario
    })
    .catch(error => {
        // Manejo de errores en caso de que la solicitud falle
        console.error('Error:', error);
        alert('Error al crear el alumno.');
    });
});

// Función para editar un estudiante
function editarEstudiante(id) {
    // Obtener los datos del estudiante a partir del ID
    fetch(`../ajax/obtener_estudiante.php?id=${id}`)
        .then(response => response.json())  // Convertir la respuesta en JSON
        .then(data => {
            // Si hay un error en los datos, mostrar un mensaje de error
            if(data.error){
                alert(data.error);
                return;
            }
            // Mostrar la sección de actualización de alumno
            mostrarSeccion('actualizar-alumno');

            // Rellenar el formulario con los datos del estudiante
            document.getElementById('id-actualizar').value = data.id;
            document.getElementById('nombre-actualizar').value = data.nombre;
            document.getElementById('apellido-actualizar').value = data.apellido;
            document.getElementById('email-actualizar').value = data.email;
            document.getElementById('edad-actualizar').value = data.edad;
        })
        .catch(error => {
            // Manejo de errores en caso de que la solicitud falle
            console.error('Error:', error);
            alert('Error al obtener los datos del alumno.');
        });
}

// Función para actualizar un estudiante
document.getElementById('form-actualizar-alumno').addEventListener('submit', function(e) {
    e.preventDefault();

    // Obtener los valores del formulario de actualización
    const id = document.getElementById('id-actualizar').value;
    const nombre = document.getElementById('nombre-actualizar').value;
    const apellido = document.getElementById('apellido-actualizar').value;
    const email = document.getElementById('email-actualizar').value;
    const edad = document.getElementById('edad-actualizar').value;

    // Enviar los datos actualizados al servidor usando fetch
    fetch('../ajax/actualizar_alumno.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id, nombre, apellido, email, edad })
    })
    .then(response => response.json())  // Convertir la respuesta en JSON
    .then(data => {
        // Mostrar un mensaje de éxito o error
        alert(data.message);
        obtenerListaEstudiantes(); // Actualizar la lista de estudiantes
        document.getElementById('form-actualizar-alumno').reset(); // Limpiar el formulario
        mostrarSeccion('lista-alumnos'); // Volver a la lista de alumnos
    })
    .catch(error => {
        // Manejo de errores en caso de que la solicitud falle
        console.error('Error:', error);
        alert('Error al actualizar el alumno.');
    });
});

// Función para eliminar un estudiante
function eliminarEstudiante(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este alumno?')) {
        // Enviar una solicitud DELETE al servidor para eliminar al estudiante
        fetch(`../ajax/eliminar_alumno.php?id=${id}`, {
            method: 'DELETE',
        })
        .then(response => response.json())  // Convertir la respuesta en JSON
        .then(data => {
            // Mostrar un mensaje de éxito o error
            alert(data.message);
            obtenerListaEstudiantes(); // Actualizar la lista de estudiantes
        })
        .catch(error => {
            // Manejo de errores en caso de que la solicitud falle
            console.error('Error:', error);
            alert('Error al eliminar el alumno.');
        });
    }
}

// Función para consultar estudiantes por curso
document.getElementById('form-estudiantes-curso').addEventListener('submit', function(e) {
    e.preventDefault();
    const cursoId = document.getElementById('curso-id').value;

    fetch('../ajax/consultar_estudiantes_curso.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ curso_id: cursoId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json(); // Convertir la respuesta en JSON
    })
    .then(data => {
        let output = '';
        if (data.error) {
            output = `<div class="alert">${data.error}</div>`;
        } else if (data.length > 0) {
            output = '<table><tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Edad</th></tr>';
            data.forEach(alumno => {
                output += `<tr>
                             <td>${alumno.id}</td>
                             <td>${alumno.nombre}</td>
                             <td>${alumno.apellido}</td>
                             <td>${alumno.email}</td>
                             <td>${alumno.edad}</td>
                           </tr>`;
            });
            output += '</table>';
        } else {
            output = '<p>No se encontraron estudiantes para este curso.</p>';
        }
        document.getElementById('resultado-estudiantes-curso').innerHTML = output;
    })
    .catch(error => {
        // Manejo de errores en caso de que la solicitud falle
        console.error('Error:', error);
        document.getElementById('resultado-estudiantes-curso').innerHTML = `<div class="alert">Error al consultar estudiantes.</div>`;
    });
});

// Función para consultar cursos de un estudiante
document.getElementById('form-cursos-estudiante').addEventListener('submit', function(e) {
    e.preventDefault();
    const estudianteId = document.getElementById('estudiante-id').value;

    fetch('../ajax/consultar_cursos_estudiante.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ estudiante_id: estudianteId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json(); // Convertir la respuesta en JSON
    })
    .then(data => {
        let output = '';
        if (data.error) {
            output = `<div class="alert">${data.error}</div>`;
        } else if (data.length > 0) {
            output = '<table><tr><th>ID</th><th>Nombre</th><th>Descripción</th></tr>';
            data.forEach(curso => {
                output += `<tr>
                             <td>${curso.id}</td>
                             <td>${curso.nombre}</td>
                             <td>${curso.descripcion}</td>
                           </tr>`;
            });
            output += '</table>';
        } else {
            output = '<p>No se encontraron cursos para este estudiante.</p>';
        }
        document.getElementById('resultado-cursos-estudiante').innerHTML = output;
    })
    .catch(error => {
        // Manejo de errores en caso de que la solicitud falle
        console.error('Error:', error);
        document.getElementById('resultado-cursos-estudiante').innerHTML = `<div class="alert">Error al consultar cursos.</div>`;
    });
});
