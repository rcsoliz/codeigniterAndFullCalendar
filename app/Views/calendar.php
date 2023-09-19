<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8' />

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.css" /> -->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.min.css'); ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

   <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.js"></script> -->
     <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script> -->

    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/main.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/moment.min.js'); ?>"></script>

    <script src="<?php echo base_url('assets/js/sweetalert2.all.min.js'); ?>"></script>
</head>

<body>

    <div class="container">
        <div id='calendar'></div>
    </div>

    <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="titulo"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form id="formulario">
                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <input type="hidden" id="id" name="id">

                            <input type="text" class="form-control" id="title" name="title" required="">
                            <label for="title" class="form-label">Cliente *</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="description" name="description">
                            <label for="description" class="form-label">Descripción</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select name="color" class="form-control" id="color" name="color">
                                <option value="">Seleccione un color *</option>
                                <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                <option style="color:#008000;" value="#008000">&#9724; Green</option>
                                <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                <option style="color:#000;" value="#000">&#9724; Black</option>
                            </select>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="datetime-local" id="start_date" name="start_date" class="form-control"
                                data-format="dd/mm/yyyy hh:mm">
                            <label for="start_date" class="form-label">Fecha Inicio *</label> 
                        </div>

                        <div class="form-floating mb-3">
                            <input type="datetime-local" id="end_date" name="end_date" class="form-control"
                                data-date-format="dd/mm/yyyy hh:mm">
                            <label for="end_date" class="form-label">Fecha Fin</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-danger" type="button" id="btnEliminar">Eliminar</button>
                        <button class="btn btn-info" id="btnAccion" type="submit">Registrar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        var BASE_URL = '<?php echo base_url(); ?>';
        var myModal = new bootstrap.Modal(document.getElementById('myModal'));
        let frm = document.getElementById('formulario');
        let eliminar = document.getElementById('btnEliminar');
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev, next, today',
                    center: 'title',
                    right: 'dayGridMonth timeGridWeek listWeek'
                },
                events: BASE_URL + 'calendar/getevents',
                editable: true,
                dateClick: function (info) {
                    console.log(info);
                    frm.reset();
                    console.log(info);
                    document.getElementById('id').value = '';
                    eliminar.classList.add('d-none');

                    var myDate = info.dateStr;
                    var myHhMm = moment().format('HH:mm');
                    var DateFormat =myDate + ' ' + myHhMm;

                    document.getElementById('title').value = '';
                    document.getElementById('description').value = '';
                    document.getElementById('start_date').value = moment(DateFormat).format("YYYY-MM-DD HH:mm");// moment(myDate).format("YYYY-MM-DD HH:mm");
                    document.getElementById('end_date').value = moment(DateFormat).add('hours',2).format("YYYY-MM-DD HH:mm");
                    document.getElementById('color').value = "#008000";
                    document.getElementById('btnAccion').textContent = 'Guardar';
                    document.getElementById('titulo').textContent = 'Citas';

                    myModal.show();
                },
                eventClick: function (info) {
                 //   console.log(info);
                    eliminar.classList.remove('d-none');
                    document.getElementById('titulo').textContent = 'Actualizar Cita';
                    document.getElementById('btnAccion').textContent = 'Actualizar';
                    document.getElementById('id').value = info.event.id;
                    document.getElementById('title').value = info.event.title;
                    document.getElementById('description').value = info.event._def.extendedProps.description;

                    var fecha = new Date(info.event._def.extendedProps.start_datetime);
                    var anio = fecha.getFullYear();
                    var mes = ('0' + (fecha.getMonth() + 1)).slice(-2);
                    var dia = ('0' + fecha.getDate()).slice(-2);
                    var horas = ('0' + fecha.getHours()).slice(-2);
                    var minutos = ('0' + fecha.getMinutes()).slice(-2);
                    var fechaFormateada = anio + '-' + mes + '-' + dia + ' ' + horas + ':' + minutos;

                    document.getElementById('start_date').value = fechaFormateada;

                    var fechaEnd = new Date(info.event._def.extendedProps.end_datetime);
                    var anioEnd = fechaEnd.getFullYear();
                    var mesEnd = ('0' + (fechaEnd.getMonth() + 1)).slice(-2);
                    var diaEnd = ('0' + fechaEnd.getDate()).slice(-2);
                    var horasEnd = ('0' + fechaEnd.getHours()).slice(-2);
                    var minutosEnd = ('0' + fechaEnd.getMinutes()).slice(-2);
                    var fechaFormateadaEnd = anioEnd + '-' + mesEnd + '-' + diaEnd + ' ' + horasEnd + ':' + minutosEnd;

                    document.getElementById('end_date').value =fechaFormateadaEnd;
                    document.getElementById('color').value = info.event._def.extendedProps.selectcolor;

                    myModal.show();
                },
                eventDrop: function (info) {
                    console.log(info)
                    const id = info.event.id;

                    const currentDate = new Date(info.event._def.extendedProps.start_datetime);

                    var start_hours = currentDate.getHours().length ==1? '0'+ currentDate.getHours(): currentDate.getHours();
                    var start_minutes = currentDate.getMinutes().length ==1? '0'+ currentDate.getMinutes(): currentDate.getMinutes();

                    var fechaStart= new Date(info.event.startStr);
                    var anioStart = fechaStart.getFullYear();
                    var mesStart = ('0' + (fechaStart.getMonth() + 1)).slice(-2);
                    var diaStart = ('0' + fechaStart.getDate()).slice(-2);
                    var horasStart = ('0' + start_hours).slice(-2);
                    var minutosStart = ('0' + start_minutes).slice(-2);
                    var fechaFormateada = anioStart + '-' + mesStart + '-' + diaStart + ' ' + horasStart + ':' + minutosStart;

                    const currentDateEnd = new Date(info.event._def.extendedProps.end_datetime);
                    var end_hours = currentDateEnd.getHours().length ==1? '0'+ currentDateEnd.getHours(): currentDateEnd.getHours();
                    var end_minutes = currentDateEnd.getMinutes().length ==1? '0'+ currentDateEnd.getMinutes(): currentDateEnd.getMinutes();

                    var fechaEnd = new Date(info.event.startStr);
                    var anioEnd = fechaEnd.getFullYear();
                    var mesEnd = ('0' + (fechaEnd.getMonth() + 1)).slice(-2);
                    var diaEnd = ('0' + fechaEnd.getDate()).slice(-2);
                    var horasEnd = ('0' + end_hours).slice(-2);
                    var minutosEnd = ('0' + end_minutes).slice(-2);
                    var fechaFormateadaEnd = anioEnd + '-' + mesEnd + '-' + diaEnd + ' ' + horasEnd + ':' + minutosEnd;


                    const url = BASE_URL + 'calendar/drop';

                    const http = new XMLHttpRequest();
                    const data = new FormData()
                    data.append('id', id);
                    data.append('start_date', fechaFormateada);
                    data.append('end_date', fechaFormateadaEnd);

                    http.open('POST', url, true);
                    http.send(data);
                    http.onreadystatechange = function () {

                        if (this.readyState == 4 && this.status == 200) {
                            // console.log(this.responseText);
                            //  const respuesta = JSON.parse(this.responseText);

                            // if (respuesta.estado) {
                            calendar.refetchEvents();
                            //}
                            Swal.fire(
                                'Aviso',
                                'Cita ajustada',
                                'success'
                            )

                        }
                    }

                }
            });
            calendar.render();
            frm.addEventListener('submit', function (e) {
                e.preventDefault();// prevenimos la recarga
                const title = document.getElementById('title').value;
                const description = document.getElementById('description').value;
                const color = document.getElementById('color').value;
                const start = document.getElementById('start_date').value;
                const end = document.getElementById('end_date').value;

                if (title == '' || start == '' || color == '') {
                    Swal.fire(
                        'Aviso',
                        'Todos los campos son requeridos',
                        'warning'
                    )
                } else {
                    const url = BASE_URL + 'calendar/crear';
                    const http = new XMLHttpRequest();
                    http.open('POST', url, true);
                    http.send(new FormData(frm));
                  // console.log(http);
                    http.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            //const respuesta = JSON.parse(this.responseText);
                            //  if ( respuesta == '1') {
                            calendar.refetchEvents();
                            //}
                            myModal.hide();
                            Swal.fire(
                                'Aviso',
                                "Cita registrada",
                                'success'
                            )
                        }
                    }
                }
            })
            eliminar.addEventListener('click', function () {
                myModal.hide();

                Swal.fire({
                    title: 'Advertencia',
                    text: "Esta seguro de eliminar?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminar!',
                    cancelButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //   const id = document.getElementById('id').value;
                        const url = BASE_URL + 'calendar/eliminar/' + document.getElementById('id').value;
                        //console.log(url);
                        const http = new XMLHttpRequest();
                        http.open('GET', url, true);
                        http.send();
                        http.onreadystatechange = function () {

                            if (this.readyState == 4 && this.status == 200) {

                                //  const respuesta = JSON.parse(this.responseText);

                                // if (respuesta.estado) {
                                calendar.refetchEvents();
                                // }
                                Swal.fire(
                                    'Aviso',
                                    "Cita eliminada",
                                    'success'
                                )

                            }
                        }

                    }
                })

            })

        });
    </script>
</body>

</html>