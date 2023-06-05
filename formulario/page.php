<?php get_header(); ?>

<main class="container seccion">
    <h1 class="text-center display-3">¡Cotiza tu <b>Seguro de Auto</b> en 30 segundos!</h1>

    <form id="formulario" class="row mt-5 needs-validation" method="post" action="<?php echo esc_url('/formulario/formulario'); ?>" novalidate>

        <!-- REQUERIMIENTO -->
        <div class="row justify-content-center text-center mb-5">
            <div class="col-md-8">
                <h2 class="fs-1 text-success fw-bold">Selecciona tu perfil</h2>
                <div class="d-flex justify-content-evenly mt-3">
                    <div class="">
                        <input type="checkbox" name="cliente" id="cliente" checked onclick="seleccionarRol('cliente')">
                        <label for="cliente" class="form-check-label fs-2">Cliente Banca</label>
                    </div>
                    <div class="">
                        <input type="checkbox" name="empleado" id="empleado" onclick="seleccionarRol('empleado')">
                        <label for="empleado" class="form-check-label fs-2">Empleado</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-5 mb-lg-0" id="datosBasicos">
            <h2 class="fs-1 text-success fw-bold">Datos básicos de tu auto</h2>
            <div class="d-flex flex-column flex-lg-row justify-content-between mt-5">
                <label for="tipo" class="form-label fs-2 text-success">¿Que auto tienes?</label>
                <div class="">
                    <input type="checkbox" name="car" id="car" checked onclick="desmarcarOtro(this)">
                    <label for="car" class="form-check-label fs-2">Auto/Suv</label>
                </div>
                <div class="">
                    <input type="checkbox" name="truck" id="truck" onclick="desmarcarOtro(this)">
                    <label for="truck" class="form-check-label fs-2">Pick Up</label>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <select class="form-select bg-body-secondary fs-2" aria-label="Marca del carro" name="detalles" id="detalles" required>
                        <option selected disabled>Marca...</option>
                    </select>
                </div>
                <div class="col-6">
                    <select class="form-select bg-body-secondary fs-2" aria-label="Año del carro" name="ano" id="ano" required>
                        <option selected disabled>Año...</option>
                    </select>
                </div>
            </div>
            <select class="form-select bg-body-secondary fs-2 mt-5" aria-label="Submarca del carro" name="submarca" id="submarca" required>
                <option selected disabled>Submarca...</option>
            </select>
            <select class="form-select bg-body-secondary fs-2 mt-5" aria-label="Descripcion del carro" name="descripcion" id="descripcion" required>
                <option selected disabled>Descripcion...</option>
                <option value="2Puerta">2 Puertas</option>
                <option value="4Puerta">4 Puertas</option>
                <option value="6Puerta">6 Puertas</option>
            </select>
        </div>
        <div class="col-12 col-lg-6">
            <h2 class="fs-1 text-success fw-bold">Datos personales</h2>
            <div class="row mt-5">
                <div class="col-6">
                    <input type="tel" name="cp" id="cp" class="form-control bg-body-secondary fs-2" placeholder="Codigo Postal" maxlength="5" required>
                </div>
                <div class="col-6">
                    <input type="tel" name="telefono" id="telefono" class="form-control bg-body-secondary fs-2" placeholder="Teléfono" maxlength="10" required>
                </div>
            </div>
            <input type="text" name="nombre" id="nombre" class="form-control bg-body-secondary fs-2 mt-5" placeholder="Nombre Completo" required>
            <input type="email" name="correo" id="correo" class="form-control bg-body-secondary fs-2 mt-5" placeholder="Correo" required>
            <!-- REQUERIMIENTO -->
            <div class="d-none" id="datosPerfil">
                <input type="text" name="empresa" id="empresa" class="form-control bg-body-secondary fs-2 mt-5" placeholder="Escribe el nombre de la Empresa a la que perteneces">
                <input type="tel" name="nomina" id="nomina" class="form-control bg-body-secondary fs-2 mt-5" placeholder="Escribe tu numero de nomina" maxlength="8">
            </div>
        </div>

        <input type="hidden" name="folio">
        <input type="hidden" name="action" value="custom_form">

        <div class="d-flex align-items-center flex-column mt-5">
            <div class="">
                <input type="checkbox" name="privacidad" id="privacidad" required>
                <label for="privacidad" class="form-label fs-3">Acepto que he leído el <b>Aviso de privacidad</b></label>
            </div>
            <input type="submit" value="Cotiza" class="d-inline btn btn-success fs-2 py-2 px-5">
        </div>
    </form>

    <div class="seccion"></div>
</main>

<?php get_footer(); ?>