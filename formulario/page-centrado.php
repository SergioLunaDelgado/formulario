<?php
/* 
* Template Name: Contenido Centrado
*/
get_header();
?>

<main class="row justify-content-center seccion">
    <div class="col-md-8 col-lg-6">
        <h1 class="text-center text-success fs-1 fw-bold"><?php the_title(); ?></h1>
        <h2 class="text-center fs-2 mt-5"><?php the_content(); ?></h2>

        <?php
        if (!isset($_GET['folio']) || empty($_GET['folio'])) {
            die();
        }
        $folio = filter_var($_GET['folio'], FILTER_SANITIZE_NUMBER_INT);
        $resultado = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}datosUsuarios u, {$wpdb->prefix}datosVehiculos v WHERE v.folio = {$folio} AND u.id = v.usuarios_id")[0];
        ?>

        <div class="table-responsive">
            <table class="table fs-2">
                <tbody>
                    <tr>
                        <th scope="row">Número de cotización:</th>
                        <td><?php echo $folio; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Cliente:</th>
                        <td><?php echo $resultado->nombre; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Teléfono:</th>
                        <td><?php echo $resultado->telefono; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Correo:</th>
                        <td><?php echo $resultado->correo; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Descripción unidad:</th>
                        <td><?php echo $resultado->detalles . ' ' . $resultado->submarca . ' ' . $resultado->descripcion; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Marca:</th>
                        <td><?php echo $resultado->detalles; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Modelo:</th>
                        <td><?php echo $resultado->submarca; ?></td>
                    </tr>
                    <?php if (!empty($resultado->empresa)) : ?>
                        <tr>
                            <th scope="row">Empresa:</th>
                            <td><?php echo $resultado->empresa; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Nomina:</th>
                            <td><?php echo $resultado->nomina; ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="seccion"></div>

<?php get_footer(); ?>