<?php
include 'config.php';

$mensaje = "";
$clase_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'get_empleados_by_piso') {
    $piso = $_GET['piso'] ?? 0;
    
    $sentencia = $conexion->prepare("SELECT id_empleado, nombre, apellido FROM empleados WHERE piso = ? ORDER BY nombre ASC");
    $sentencia->bind_param("i", $piso);
    $sentencia->execute();
    $resultado = $sentencia->get_result();

    $empleados = [];
    while ($fila = $resultado->fetch_assoc()) {
        $empleados[] = $fila;
    }
    
    header('Content-Type: application/json');
    echo json_encode($empleados);
    $sentencia->close();
    exit();
    
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['empleado_registro'])) {
    $nombre = $_POST['nombre_empleado'];
    $apellido = $_POST['apellido_empleado'];
    $puesto = $_POST['puesto_empleado'];
    $piso = $_POST['piso_empleado'];
 
    $sentencia_verificacion = $conexion->prepare("SELECT id_empleado FROM empleados WHERE nombre = ? AND apellido = ?");
    $sentencia_verificacion->bind_param("ss", $nombre, $apellido);
    $sentencia_verificacion->execute();
    $sentencia_verificacion->store_result();
 
    if ($sentencia_verificacion->num_rows > 0) {
        $mensaje = "Error: Ya existe un empleado con el nombre '{$nombre} {$apellido}'.";
        $clase_mensaje = "error";
    } else {
 
        $sentencia = $conexion->prepare("INSERT INTO empleados (nombre, apellido, puesto, piso) VALUES (?, ?, ?, ?)");
        $sentencia->bind_param("sssi", $nombre, $apellido, $puesto, $piso);
       
        if ($sentencia->execute()) {
            $mensaje = "Empleado registrado exitosamente.";
            $clase_mensaje = "success";
        } else {
            $mensaje = "Error al registrar empleado: " . $sentencia->error;
            $clase_mensaje = "error";
        }
        $sentencia->close();
    }
    $sentencia_verificacion->close();
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['visitante_registro'])) {
    $nombre = $_POST['nombre_visitante'];
    $apellido = $_POST['apellido_visitante'];
    $motivo = $_POST['motivo_visita'];
   
    $sentencia_visitante = $conexion->prepare("INSERT INTO visitantes (nombre, apellido, motivo_visita) VALUES (?, ?, ?)");
    $sentencia_visitante->bind_param("sss", $nombre, $apellido, $motivo);
 
    if ($sentencia_visitante->execute()) {
 
        $id_visitante = $sentencia_visitante->insert_id;
        $tipo_persona = "visitante";
       
        $sentencia_acceso = $conexion->prepare("INSERT INTO registros (id_persona, tipo_persona, fecha_hora_entrada) VALUES (?, ?, NOW())");
        $sentencia_acceso->bind_param("is", $id_visitante, $tipo_persona);
 
        if ($sentencia_acceso->execute()) {
            $mensaje = "Visitante registrado y su acceso se ha registrado exitosamente.";
            $clase_mensaje = "success";
        } else {
            $mensaje = "Visitante registrado, pero hubo un error al registrar su acceso: " . $sentencia_acceso->error;
            $clase_mensaje = "error";
        }
        $sentencia_acceso->close();
    } else {
        $mensaje = "Error al registrar visitante: " . $sentencia_visitante->error;
        $clase_mensaje = "error";
    }
    $sentencia_visitante->close();
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_acceso'])) {
    $tipo_persona = "empleado";
    $id_persona = $_POST['id_empleado_acceso'];
 
    $sentencia = $conexion->prepare("INSERT INTO registros (id_persona, tipo_persona, fecha_hora_entrada) VALUES (?, ?, NOW())");
    $sentencia->bind_param("is", $id_persona, $tipo_persona);
 
    if ($sentencia->execute()) {
        $mensaje = "Acceso de empleado registrado correctamente.";
        $clase_mensaje = "success";
    } else {
        $mensaje = "Error al registrar acceso: " . $sentencia->error;
        $clase_mensaje = "error";
    }
    $sentencia->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso a la editorial</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<div class="login-container">
    <div class="image-section">
        <h1>Acceso a la editorial</h1>
    </div>
    <div class="form-section">
        <div class="nav-menu">
            <a href="?action=empleado"><img src="usuario-plus.png" class="boton-icono" alt="">Nuevo empleado</a>
            <a href="?action=acceso"><img src="maletin.png" class="boton-icono" alt="boton-icono">Acceso a empleado</a>
            <a href="?action=visitante"><img src="tarjeta-de-visita.png" class="boton-icono" alt="boton-icono">Acceso a visitante</a>
            <a href="?action=consultar"><img src="log-data.png" class="boton-icono" alt="boton-icono">Consultar</a>
        </div>
        
        <?php

        $accion = $_GET['action'] ?? 'inicio';

        if ($accion == 'empleado') {
            ?>
            <h2>Registrar nuevo empleado</h2>
            <?php

            if (!empty($mensaje)) {
                echo "<div class='message-box " . $clase_mensaje . "'><p>" . $mensaje . "</p></div>";
            }
            ?>
            <form method="post" action="">
                <label for="nombre_empleado">Nombre:</label>
                <input type="text" id="nombre_empleado" name="nombre_empleado" required>
                <label for="apellido_empleado">Apellido:</label>
                <input type="text" id="apellido_empleado" name="apellido_empleado" required>
                <label for="puesto_empleado">Puesto:</label>
                <input type="text" id="puesto_empleado" name="puesto_empleado" required>
                <label for="piso_empleado">Piso:</label>
                <input type="number" id="piso_empleado" name="piso_empleado" required>
                <button type="submit" name="empleado_registro">Registrar empleado</button>
            </form>
            <?php
        } elseif ($accion == 'visitante') {
            ?>
            <h2>Registrar acceso de visitante</h2>
            <?php
            if (!empty($mensaje)) {
                echo "<div class='message-box " . $clase_mensaje . "'><p>" . $mensaje . "</p></div>";
            }
            ?>
            <form method="post" action="">
                <label for="nombre_visitante">Nombre:</label>
                <input type="text" id="nombre_visitante" name="nombre_visitante" required>
                <label for="apellido_visitante">Apellido:</label>
                <input type="text" id="apellido_visitante" name="apellido_visitante" required>
                <label for="motivo_visita">Motivo de la visita:</label>
                <input type="text" id="motivo_visita" name="motivo_visita" required>
                <button type="submit" name="visitante_registro">Registrar entrada</button>
            </form>
            <?php
        } elseif ($accion == 'acceso') {
            ?>
            <h2>Registrar acceso de empleado</h2>
            <?php
            if (!empty($mensaje)) {
                echo "<div class='message-box " . $clase_mensaje . "'><p>" . $mensaje . "</p></div>";
            }
            ?>
            <form method="post" action="">
                <p>Selecciona el piso y luego el nombre del empleado para registrar su entrada.</p>
                <label for="piso_empleado_acceso">Piso:</label>
                <select id="piso_empleado_acceso" name="piso_empleado_acceso" required>
                    <option value="">Selecciona un piso</option>
                    <?php

                    $sql_pisos = "SELECT DISTINCT piso FROM empleados ORDER BY piso ASC";
                    $resultado_pisos = $conexion->query($sql_pisos);
                    
                    if ($resultado_pisos->num_rows > 0) {
                        while($fila_piso = $resultado_pisos->fetch_assoc()) {
                            echo "<option value='" . $fila_piso['piso'] . "'>" . $fila_piso['piso'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay pisos registrados</option>";
                    }
                    ?>
                </select>
                <label for="id_empleado_acceso">Empleado:</label>
                <select id="id_empleado_acceso" name="id_empleado_acceso" required>
                    <option value="">Selecciona un piso primero</option>
                </select>
                <button type="submit" name="registrar_acceso">Registrar entrada</button>
            </form>
            <?php
        } elseif ($accion == 'consultar') {
            ?>
            <h2>Consultar registros de acceso</h2>
            <table>
                <thead>
                    <tr>
                        <th>Empleado/Visitante</th>
                        <th>Puesto</th>
                        <th>Nombre completo</th>
                        <th>Fecha y hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "
                        SELECT
                            r.tipo_persona,
                            r.fecha_hora_entrada,
                            e.puesto,
                            e.nombre AS nombre_empleado,
                            e.apellido AS apellido_empleado,
                            v.nombre AS nombre_visitante,
                            v.apellido AS apellido_visitante,
                            v.motivo_visita
                        FROM registros AS r
                        LEFT JOIN empleados AS e ON r.id_persona = e.id_empleado AND r.tipo_persona = 'empleado'
                        LEFT JOIN visitantes AS v ON r.id_persona = v.id_visitante AND r.tipo_persona = 'visitante'
                        ORDER BY r.fecha_hora_entrada DESC
                        LIMIT 50";
                    $resultado = $conexion->query($sql);

                    if ($resultado->num_rows > 0) {
                        while($fila = $resultado->fetch_assoc()) {

                            if ($fila['tipo_persona'] == 'empleado') {
                                $nombre_completo = $fila['nombre_empleado'] . " " . $fila['apellido_empleado'];
                                $puesto = $fila['puesto'];
                                $mostrar_persona = $fila['tipo_persona'];
                            } else {
                                $nombre_completo = $fila['nombre_visitante'] . " " . $fila['apellido_visitante'];
                                $puesto = "N/A";
                                $mostrar_persona = "visitante (" . $fila['motivo_visita'] . ")";
                            }

                            echo "<tr>";
                            echo "<td>" . $mostrar_persona . "</td>";
                            echo "<td>" . $puesto . "</td>";
                            echo "<td>" . $nombre_completo . "</td>";
                            echo "<td>" . $fila["fecha_hora_entrada"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No hay registros.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            ?>
            <h2>Acceso a la editorial</h2>
            <p>Selecciona una opción del menú para comenzar.</p>
            <?php
        }
        ?>
    </div>
</div>

<script src="AbrirVentana.js"></script>

</body>
</html>