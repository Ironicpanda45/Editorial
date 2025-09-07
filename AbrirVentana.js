    document.getElementById('piso_empleado_acceso').addEventListener('change', function() {
        const piso = this.value;
        const selectorEmpleado = document.getElementById('id_empleado_acceso');
        
        selectorEmpleado.innerHTML = '<option value="">Cargando empleados...</option>';
        selectorEmpleado.disabled = true;

        if (piso === "") {
            selectorEmpleado.innerHTML = '<option value="">Selecciona un piso primero</option>';
            selectorEmpleado.disabled = false;
            return;
        }

        fetch(`index.php?action=get_empleados_by_piso&piso=${piso}`)
            .then(response => response.json())
            .then(datos => {
                selectorEmpleado.innerHTML = '';
                if (datos.length > 0) {
                    datos.forEach(empleado => {
                        const opcion = document.createElement('option');
                        opcion.value = empleado.id_empleado;
                        opcion.textContent = `${empleado.nombre} ${empleado.apellido}`;
                        selectorEmpleado.appendChild(opcion);
                    });
                } else {
                    selectorEmpleado.innerHTML = '<option value="">No hay empleados en este piso</option>';
                }
                selectorEmpleado.disabled = false;
            })
            .catch(error => {
                console.error('Error al obtener los empleados:', error);
                selectorEmpleado.innerHTML = '<option value="">Error al cargar empleados</option>';
                selectorEmpleado.disabled = false;
            });
    });