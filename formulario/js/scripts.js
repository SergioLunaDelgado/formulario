function desmarcarOtro(checkbox) {
    let checkboxes = document.querySelectorAll('#datosBasicos input[type="checkbox"]');
    checkboxes.forEach(function (element) {
        if (element !== checkbox) {
            element.checked = false;
        } else {
            element.checked = true;
            buscarMarca(element.id);
        }
    });
}

/* Requerimiento */
function seleccionarRol(rol) {
    const empleado = document.querySelector('#formulario #empleado');
    const cliente = document.querySelector('#formulario #cliente');
    const datosPerfil = document.querySelector('#formulario #datosPerfil');

    if (rol === 'empleado') {
        cliente.checked = false;
        empleado.checked = true;
        datosPerfil.classList.remove('d-none');
    } else if (rol === 'cliente') {
        empleado.checked = false;
        cliente.checked = true;
        datosPerfil.classList.add('d-none');
    }
}

function buscarMarca(marca) {
    // Realizar solicitud AJAX a la API de NHTSA
    const url = `https://vpic.nhtsa.dot.gov/api/vehicles/GetMakesForVehicleType/${marca}?format=json`;

    // Crear una instancia del objeto XMLHttpRequest
    const xhr = new XMLHttpRequest();
    // console.log(xhr);

    // Configurar la solicitud AJAX
    xhr.open('GET', url, true);

    // Configurar el callback para cuando la solicitud AJAX se complete
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            // Obtener las marcas del objeto de respuesta
            const marcas = response.Results.map(result => {
                return {
                    MakeId: result.MakeId,
                    MakeName: result.MakeName
                };
            });

            // Actualizar el select con las marcas obtenidas
            const selectMarcas = document.querySelector('#detalles');
            selectMarcas.innerHTML = '';
            const marcaDefault = document.createElement('OPTION');
            marcaDefault.text = 'Marca...';
            selectMarcas.add(marcaDefault);

            marcas.forEach(marca => {
                const option = document.createElement('option');
                option.text = marca.MakeName;
                option.dataset.marcaId = marca.MakeId;
                option.value = marca.MakeName;
                selectMarcas.add(option);
            });
        } else {
            console.error('Error al obtener las marcas de autos');
        }
    };

    // Enviar la solicitud AJAX
    xhr.send();
}

const selectMarcas = document.querySelector('#detalles');
if (selectMarcas) {
    selectMarcas.addEventListener('change', function () {
        const optionSeleccionado = selectMarcas.selectedOptions[0];
        const valorAtributo = optionSeleccionado.getAttribute('data-marca-id');

        buscarSubMarca(valorAtributo);
        buscarAno();
    });
}

function buscarSubMarca(id) {
    // Realizar solicitud AJAX a la API de NHTSA
    const url = `https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMakeId/${id}?format=json`;

    // Crear una instancia del objeto XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Configurar la solicitud AJAX
    xhr.open('GET', url, true);

    // Configurar el callback para cuando la solicitud AJAX se complete
    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            // Obtener las Submarcas del objeto de respuesta
            const submarcas = response.Results.map(result => result.Model_Name);

            // Actualizar el select con las Submarcas obtenidas
            const selectSubMarcas = document.querySelector('#submarca');
            selectSubMarcas.innerHTML = '';
            const marcaDefault = document.createElement('OPTION');
            marcaDefault.text = 'Submarca...';
            selectSubMarcas.add(marcaDefault);

            submarcas.forEach(submarca => {
                const option = document.createElement('option');
                option.text = submarca;
                option.value = submarca;
                selectSubMarcas.add(option);
            });
        } else {
            console.error('Error al obtener las submarcas de autos');
        }
    };

    // Enviar la solicitud AJAX
    xhr.send();
}

function buscarAno() {
    const selectAno = document.querySelector('#ano');
    selectAno.innerHTML = '';
    const optionDefault = document.createElement('OPTION')
    optionDefault.text = 'Año...';
    selectAno.add(optionDefault);
    let year = 2023;
    let i = 0;
    while (i <= 10) {
        const option = document.createElement('OPTION');
        option.text = year;
        option.value = year;
        selectAno.add(option);
        year--;
        i++;
    }
}

const sumbitFormulario = document.querySelector('#formulario');
if (sumbitFormulario) {
    buscarMarca('car');

    const nombre = jQuery('#nombre').val();
    const detalles = jQuery('#detalles').val();
    const submarca = jQuery('#submarca').val();
    const descripcion = jQuery('#descripcion').val();
    sumbitFormulario.addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = jQuery(this).serialize();
        // console.log(formData);

        jQuery.ajax({
            url: 'http://localhost/formulario/formulario/',
            method: 'POST',
            data: formData,
            success: function (response) {
                console.log(response.message);
                alert(`Gracias, ${response.nombre} Hemos recibido tus datos y en breve te contactará un asesor especializado, para apoyarte con cualquier detalle relacionado con la cotización de tu Seguro de Auto para: ${response.datos_auto}`);
                window.location.href = 'http://localhost/formulario/seguimiento?folio=' + response.folio;
            },
            error: function (xhr, status, error) {
                console.log(response.message);
            }
        });

    });
}


(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()