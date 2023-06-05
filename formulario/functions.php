<?php

function formulario_setup()
{
    /* Titulos para SEO */
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'formulario_setup');

function formulario_scrips_styles()
{
    /* CSS */
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0');
    wp_enqueue_style('style', get_stylesheet_uri(), array(), '1.0.0');

    /* JS */
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true);
    wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'formulario_scrips_styles');

// Función para comprobar si la tabla existe en la base de datos
function verificar_tabla_personalizada()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'datosUsuarios';

    // Verificar si la tabla existe en la base de datos
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        // La tabla no existe, llamar a la función para crearla
        crear_tabla_personalizada();
    }
}
// Verificar y crear la tabla al activar el tema
add_action('after_switch_theme', 'verificar_tabla_personalizada');

// Función para crear la tabla personalizada
function crear_tabla_personalizada()
{
    global $wpdb;
    $datosUsuarios = $wpdb->prefix . 'datosUsuarios';
    $datosVehiculos = $wpdb->prefix . 'datosVehiculos';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $datosUsuarios (
        id INT(11) NOT NULL AUTO_INCREMENT,
        cp INT(8) NOT NULL,
        telefono INT(10) NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        correo VARCHAR(60) NOT NULL,
        empresa VARCHAR(60),
        nomina int(8),
        PRIMARY KEY (id)
    ) $charset_collate;
    
    CREATE TABLE $datosVehiculos (
        id INT(11) NOT NULL AUTO_INCREMENT,
        usuarios_id INT(11) NOT NULL,
        folio INT(7) NOT NULL,
        detalles VARCHAR(30) NOT NULL,
        ano int(4) NOT NULL,
        submarca VARCHAR(30) NOT NULL,
        descripcion VARCHAR(60) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (usuarios_id) REFERENCES $datosUsuarios(id) ON DELETE CASCADE
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Registrar el endpoint personalizado
function registrar_endpoint_personalizado()
{
    add_rewrite_endpoint('formulario/formulario', EP_ROOT);
}
add_action('init', 'registrar_endpoint_personalizado');

// Callback para procesar la petición POST en el endpoint
function procesar_peticion_post()
{
    // Verificar si se ha enviado el formulario
    if (isset($_POST['action']) && $_POST['action'] === 'custom_form') {
        $folio = $_POST['folio'] = mt_rand(1000000, 9999999);

        /* se puede agregar una validacion para no repetir clientes con su correo */

        // Inserta los datos en la tabla personalizada
        global $wpdb;
        $table_datosUsuarios = $wpdb->prefix . 'datosUsuarios';
        $data_user = array(
            'cp' => absint($_POST['cp']),
            'telefono' => absint($_POST['telefono']),
            'nombre' => sanitize_text_field($_POST['nombre']),
            'correo' => sanitize_email($_POST['correo']),
            'empresa' => sanitize_text_field($_POST['empresa']),
            'nomina' => absint($_POST['nomina']),
        );
        $wpdb->insert($table_datosUsuarios, $data_user);

        $usuario_id = $wpdb->get_results("SELECT max(id) as id FROM {$wpdb->prefix}datosUsuarios");
        $table_datosVehiculos = $wpdb->prefix . 'datosVehiculos';
        $data_car = array(
            'usuarios_id' => $usuario_id[0]->id,
            'folio' => $folio,
            'detalles' => sanitize_text_field($_POST['detalles']),
            'ano' => absint($_POST['ano']),
            'submarca' => sanitize_text_field($_POST['submarca']),
            'descripcion' => sanitize_text_field($_POST['descripcion']),
        );
        $wpdb->insert($table_datosVehiculos, $data_car);

        // Verifica si ocurrió un error al insertar los datos
        if ($wpdb->last_error) {
            $data = array(
                'status'     => 'error',
                'code'         => 400,
                'message'     => 'Hubo un error',
            );
        } else {
            $data = array(
                'status'     => 'success',
                'code'         => 200,
                'message'     => 'Registro creado correctamente',
                'folio'     => $folio,
                'nombre'     => $_POST['nombre'],
                'datos_auto'     => $_POST['detalles'] . ' ' . $_POST['submarca'] . ' ' . $_POST['descripcion'],
            );
        }

        wp_send_json($data);
    }
}
add_action('template_redirect', 'procesar_peticion_post');

// function cotizar() {
//     if(isset($_GET['folio'])) {
//         // $valor = sanitize_text_field($_GET['folio']);
//         // $folio = filter_var($_GET['folio'], FILTER_SANITIZE_NUMBER_INT);
//         $folio = filter_var($_GET['folio'], FILTER_VALIDATE_INT);
//         echo "<pre>";
//         var_dump($folio);
//         echo "</pre>";
//         die();
//     }
// }
// add_action('init', 'cotizar');