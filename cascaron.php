<?php
$nombreSistema = "MediCitas";
$seccion = $_GET['seccion'] ?? 'inicio';

$seccionesPermitidas = ['inicio', 'citas', 'pacientes', 'administracion'];

if (!in_array($seccion, $seccionesPermitidas, true)) {
    $seccion = 'inicio';
}

$citasDemo = [
    [
        'paciente' => 'María González',
        'especialidad' => 'Medicina general',
        'fecha' => '12/10/2026',
        'hora' => '09:00 AM',
        'estado' => 'Confirmada'
    ],
    [
        'paciente' => 'Carlos Ramírez',
        'especialidad' => 'Pediatría',
        'fecha' => '12/10/2026',
        'hora' => '10:30 AM',
        'estado' => 'Pendiente'
    ],
    [
        'paciente' => 'Laura Martínez',
        'especialidad' => 'Dermatología',
        'fecha' => '13/10/2026',
        'hora' => '11:00 AM',
        'estado' => 'Confirmada'
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($nombreSistema) ?> | Sistema médico</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f7f8;
            color: #243746;
        }

        a {
            text-decoration: none;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* MENU LATERAL */
        .sidebar {
            width: 245px;
            background: #153d42;
            color: white;
            padding: 28px 18px;
            flex-shrink: 0;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .logo span {
            color: #62d6bb;
        }

        .sublogo {
            font-size: 12px;
            color: #b8d1d0;
            margin-bottom: 40px;
        }

        .menu-titulo {
            color: #9ebdbc;
            font-size: 11px;
            font-weight: bold;
            margin: 25px 12px 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu a {
            display: block;
            color: #d8e7e6;
            padding: 14px 13px;
            border-radius: 9px;
            margin-bottom: 7px;
            font-size: 14px;
            transition: .2s;
        }

        .menu a:hover,
        .menu a.activo {
            background: #286064;
            color: #ffffff;
        }

        .menu a.activo {
            border-left: 4px solid #62d6bb;
        }

        .ayuda {
            margin-top: 45px;
            padding: 17px;
            background: #204b4f;
            border-radius: 12px;
            font-size: 12px;
            line-height: 1.7;
            color: #d8e7e6;
        }

        /* CONTENIDO PRINCIPAL */
        .contenido {
            flex: 1;
            min-width: 0;
        }

        .barra-superior {
            background: white;
            padding: 20px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #e5eded;
        }

        .busqueda {
            padding: 11px 14px;
            width: 270px;
            max-width: 100%;
            border: 1px solid #dce5e5;
            border-radius: 8px;
            background: #f8fbfb;
        }

        .usuario {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
        }

        .avatar {
            background: #d9f3ec;
            color: #176a5d;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            font-weight: bold;
        }

        .principal {
            padding: 32px;
        }

        .encabezado-pagina {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        h1 {
            font-size: 27px;
            margin-bottom: 9px;
        }

        .descripcion {
            color: #788b91;
            font-size: 14px;
        }

        .boton {
            display: inline-block;
            padding: 12px 17px;
            background: #168575;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }

        .boton:hover {
            background: #106b5e;
        }

        .boton-secundario {
            display: inline-block;
            padding: 10px 14px;
            border: 1px solid #dce6e5;
            color: #36565a;
            background: white;
            border-radius: 8px;
            cursor: pointer;
        }

        /* TARJETAS */
        .estadisticas {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        .tarjeta {
            background: white;
            padding: 23px;
            border-radius: 13px;
            border: 1px solid #e8eeee;
            box-shadow: 0 4px 14px rgba(30, 70, 70, .025);
        }

        .tarjeta-icono {
            width: 43px;
            height: 43px;
            border-radius: 11px;
            background: #e2f5ef;
            display: grid;
            place-items: center;
            font-size: 22px;
            margin-bottom: 18px;
        }

        .tarjeta p {
            font-size: 13px;
            color: #7c8d91;
            margin-bottom: 10px;
        }

        .numero {
            font-size: 29px;
            font-weight: bold;
            color: #243f43;
        }

        .nota {
            font-size: 11px;
            color: #168575;
            margin-top: 10px;
        }

        /* PANELES */
        .panel {
            background: white;
            border: 1px solid #e8eeee;
            border-radius: 13px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .panel-cabecera {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        h2 {
            font-size: 18px;
        }

        .tabla-contenedor {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 620px;
        }

        th, td {
            text-align: left;
            padding: 16px 12px;
            border-bottom: 1px solid #edf1f1;
            font-size: 13px;
        }

        th {
            color: #788b91;
            background: #f8fbfb;
            font-size: 11px;
            text-transform: uppercase;
        }

        .estado {
            display: inline-block;
            padding: 7px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .confirmada {
            background: #e1f6eb;
            color: #198052;
        }

        .pendiente {
            background: #fff1d5;
            color: #a56b0c;
        }

        .cancelada {
            background: #fde6e6;
            color: #b43d3d;
        }

        /* FORMULARIO */
        .formulario {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .campo {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .campo label {
            font-size: 13px;
            font-weight: bold;
        }

        .campo input,
        .campo select,
        .campo textarea {
            width: 100%;
            padding: 13px;
            border: 1px solid #dce5e5;
            border-radius: 8px;
            font-family: inherit;
            background: white;
        }

        .campo textarea {
            resize: vertical;
            min-height: 90px;
        }

        .campo-completo {
            grid-column: 1 / -1;
        }

        .acciones-formulario {
            grid-column: 1 / -1;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* ACCESOS RAPIDOS */
        .accesos {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 17px;
        }

        .acceso {
            border: 1px solid #e4eded;
            padding: 22px;
            border-radius: 12px;
            color: #29484a;
            display: block;
        }

        .acceso:hover {
            border-color: #168575;
            background: #f7fcfa;
        }

        .acceso span {
            font-size: 27px;
        }

        .acceso h3 {
            font-size: 15px;
            margin: 15px 0 9px;
        }

        .acceso p {
            color: #788b91;
            font-size: 12px;
            line-height: 1.6;
        }

        .pie {
            padding: 22px 32px;
            color: #89999c;
            font-size: 12px;
            text-align: center;
        }

        .mensaje {
            background: #e1f6eb;
            color: #176d4b;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        @media (max-width: 1100px) {
            .estadisticas {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .accesos {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
            }

            .sublogo {
                margin-bottom: 20px;
            }

            .menu {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 5px;
            }

            .menu-titulo {
                margin-top: 15px;
            }

            .ayuda {
                display: none;
            }

            .barra-superior {
                padding: 17px;
                flex-wrap: wrap;
            }

            .principal {
                padding: 18px;
            }

            .estadisticas {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .tarjeta {
                padding: 16px;
            }

            .numero {
                font-size: 24px;
            }

            .formulario {
                grid-template-columns: 1fr;
            }

            .campo-completo,
            .acciones-formulario {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="logo">✚ Medi<span>Citas</span></div>
        <p class="sublogo">Sistema de gestión médica</p>

        <p class="menu-titulo">Menú principal</p>

        <nav class="menu">
            <a class="<?= $seccion === 'inicio' ? 'activo' : '' ?>"
               href="?seccion=inicio">⌂ &nbsp; Inicio</a>

            <a class="<?= $seccion === 'citas' ? 'activo' : '' ?>"
               href="?seccion=citas">▣ &nbsp; Citas médicas</a>

            <a class="<?= $seccion === 'pacientes' ? 'activo' : '' ?>"
               href="?seccion=pacientes">♙ &nbsp; Pacientes</a>

            <a class="<?= $seccion === 'administracion' ? 'activo' : '' ?>"
               href="?seccion=administracion">⚙️ &nbsp; Administración</a>
        </nav>

        <div class="ayuda">
            <strong>Centro de ayuda</strong>
            <p>Administra las solicitudes de citas y organiza la atención de los pacientes.</p>
        </div>
    </aside>

    <div class="contenido">

        <header class="barra-superior">
            <input class="busqueda"
                   type="search"
                   placeholder="Buscar..."
                   aria-label="Buscar">

            <div class="usuario">
                <div class="avatar">AD</div>
                <div>
                    <strong>Administrador</strong>
                    <p style="color:#788b91; margin-top:5px;">Panel de control</p>
                </div>
            </div>
        </header>

        <main class="principal">

            <?php if ($seccion === 'inicio'): ?>

                <div class="encabezado-pagina">
                    <div>
                        <h1>¡Bienvenido a MediCitas!</h1>
                        <p class="descripcion">
                            Resumen general de la gestión de citas médicas.
                        </p>
                    </div>

                    <a class="boton" href="?seccion=citas">
                        + Nueva cita
                    </a>
                </div>

                <section class="estadisticas">
                    <div class="tarjeta">
                        <div class="tarjeta-icono">▣</div>
                        <p>Citas registradas</p>
                        <div class="numero">24</div>
                        <div class="nota">Datos de demostración</div>
                    </div>

                    <div class="tarjeta">
                        <div class="tarjeta-icono">✓</div>
                        <p>Citas confirmadas</p>
                        <div class="numero">16</div>
                        <div class="nota">Datos de demostración</div>
                    </div>

                    <div class="tarjeta">
                        <div class="tarjeta-icono">◷</div>
                        <p>Citas pendientes</p>
                        <div class="numero">5</div>
                        <div class="nota">Requieren revisión</div>
                    </div>

                    <div class="tarjeta">
                        <div class="tarjeta-icono">♙</div>
                        <p>Pacientes registrados</p>
                        <div class="numero">32</div>
                        <div class="nota">Datos de demostración</div>
                    </div>
                </section>

                <section class="panel">
                    <div class="panel-cabecera">
                        <h2>Citas recientes</h2>
                        <a href="?seccion=citas" class="boton-secundario">
                            Ver todas
                        </a>
                    </div>

                    <div class="tabla-contenedor">
                        <table>
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Especialidad</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($citasDemo as $cita): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cita['paciente']) ?></td>
                                        <td><?= htmlspecialchars($cita['especialidad']) ?></td>
                                        <td><?= htmlspecialchars($cita['fecha']) ?></td>
                                        <td><?= htmlspecialchars($cita['hora']) ?></td>
                                        <td>
                                            <span class="estado <?= $cita['estado'] === 'Confirmada' ? 'confirmada' : 'pendiente' ?>">
                                                <?= htmlspecialchars($cita['estado']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="panel">
                    <div class="panel-cabecera">
                        <h2>Accesos rápidos</h2>
                    </div>

                    <div class="accesos">
                        <a class="acceso" href="?seccion=citas">
                            <span>📅</span>
                            <h3>Agendar una cita</h3>
                            <p>Capturar los datos de una nueva solicitud médica.</p>
                        </a>

                        <a class="acceso" href="?seccion=pacientes">
                            <span>👥</span>
                            <h3>Pacientes</h3>
                            <p>Consultar el apartado de pacientes registrados.</p>
                        </a>

                        <a class="acceso" href="?seccion=administracion">
                            <span>⚙️</span>
                            <h3>Administración</h3>
                            <p>Consultar las opciones de gestión del sistema.</p>
                        </a>
                    </div>
                </section>

            <?php elseif ($seccion === 'citas'): ?>

                <div class="encabezado-pagina">
                    <div>
                        <h1>Solicitar una cita médica</h1>
                        <p class="descripcion">
                            Completa el formulario para solicitar una consulta.
                        </p>
                    </div>
                </div>

                <section class="panel">
                    <div class="panel-cabecera">
                        <h2>Datos del paciente y la cita</h2>
                    </div>

                    <form class="formulario"
                          method="post"
                          action="?seccion=citas">

                        <div class="campo">
                            <label for="nombre">Nombre completo</label>
                            <input id="nombre" name="nombre"
                                   type="text" required
                                   placeholder="Nombre del paciente">
                        </div>

                        <div class="campo">
                            <label for="correo">Correo electrónico</label>
                            <input id="correo" name="correo"
                                   type="email" required
                                   placeholder="correo@ejemplo.com">
                        </div>

                        <div class="campo">
                            <label for="telefono">Teléfono</label>
                            <input id="telefono" name="telefono"
                                   type="tel" required
                                   placeholder="Número de contacto">
                        </div>

                        <div class="campo">
                            <label for="especialidad">Especialidad</label>
                            <select id="especialidad" name="especialidad" required>
                                <option value="">Selecciona una especialidad</option>
                                <option>Medicina general</option>
                                <option>Pediatría</option>
                                <option>Dermatología</option>
                                <option>Odontología</option>
                                <option>Ginecología</option>
                            </select>
                        </div>

                        <div class="campo">
                            <label for="fecha">Fecha preferida</label>
                            <input id="fecha" name="fecha"
                                   type="date" required>
                        </div>

                        <div class="campo">
                            <label for="hora">Horario preferido</label>
                            <select id="hora" name="hora" required>
                                <option value="">Selecciona un horario</option>
                                <option>09:00</option>
                                <option>10:00</option>
                                <option>11:00</option>
                                <option>12:00</option>
                                <option>13:00</option>
                                <option>16:00</option>
                            </select>
                        </div>

                        <div class="campo campo-completo">
                            <label for="motivo">Motivo de la consulta (opcional)</label>
                            <textarea id="motivo" name="motivo"
                                      placeholder="Escribe el motivo general de tu cita"></textarea>
                        </div>

                        <div class="acciones-formulario">
                            <button class="boton" type="submit">
                                Solicitar cita
                            </button>

                            <a class="boton-secundario" href="?seccion=inicio">
                                Cancelar
                            </a>
                        </div>

                    </form>

                    <p class="descripcion" style="margin-top:20px;">
                        Maqueta de demostración: la solicitud aún no se guarda.
                    </p>
                </section>

            <?php elseif ($seccion === 'pacientes'): ?>

                <div class="encabezado-pagina">
                    <div>
                        <h1>Pacientes</h1>
                        <p class="descripcion">
                            Apartado de consulta y gestión de pacientes.
                        </p>
                    </div>

                    <button class="boton" type="button"
                            onclick="alert('Función pendiente de desarrollo')">
                        + Nuevo paciente
                    </button>
                </div>

                <section class="panel">
                    <div class="panel-cabecera">
                        <h2>Directorio de pacientes</h2>
                    </div>

                    <div class="tabla-contenedor">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        Aquí aparecerán los pacientes registrados
                                        cuando se conecte la base de datos.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

            <?php elseif ($seccion === 'administracion'): ?>

                <div class="encabezado-pagina">
                    <div>
                        <h1>Administración</h1>
                        <p class="descripcion">
                            Opciones generales del sistema de citas médicas.
                        </p>
                    </div>
                </div>

                <section class="estadisticas">
                    <div class="tarjeta">
                        <div class="tarjeta-icono">📅</div>
                        <p>Gestión de citas</p>
                        <div class="numero" style="font-size:18px;">Solicitudes</div>
                        <p style="margin-top:12px;">Revisar citas y sus estados.</p>
                    </div>

                    <div class="tarjeta">
                        <div class="tarjeta-icono">👥</div>
                        <p>Gestión de pacientes</p>
                        <div class="numero" style="font-size:18px;">Directorio</div>
                        <p style="margin-top:12px;">Consultar datos de contacto.</p>
                    </div>

                    <div class="tarjeta">
                        <div class="tarjeta-icono">⚙️</div>
                        <p>Configuración</p>
                        <div class="numero" style="font-size:18px;">Sistema</div>
                        <p style="margin-top:12px;">Opciones futuras de configuración.</p>
                    </div>

                    <div class="tarjeta">
                        <div class="tarjeta-icono">📊</div>
                        <p>Reportes</p>
                        <div class="numero" style="font-size:18px;">Consultas</div>
                        <p style="margin-top:12px;">Resumen de actividad.</p>
                    </div>
                </section>

                <section class="panel">
                    <h2>Funciones pendientes</h2>
                    <p class="descripcion" style="margin-top:14px; line-height:1.8;">
                        Conectar la base de datos, autenticar al administrador,
                        gestionar estados de las citas y habilitar los reportes.
                    </p>
                </section>

            <?php endif; ?>

        </main>

        <footer class="pie">
            © <?= date('Y') ?> MediCitas · Sistema de citas médicas
            · Proyecto de demostración
        </footer>

    </div>
</div>
</body>
</html>