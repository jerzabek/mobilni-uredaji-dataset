<?php include 'auth0.php'; ?>
<!DOCTYPE html>
<html lang="en" prefix="schemaorg: https://schema.org/">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Meta data -->
  <meta name="description" content="Otvoreni skup podataka koji opisuje mobilne uređaje">
  <meta name="keywords" content="linked data, open data, phones, dataset, mobilni uređaju, skup podataka">
  <meta name="author" content="Ivan Jeržabek">

  <meta property="og:title" content="Mobilni uređaji dataset" />
  <meta property="og:type" content="schemaorg:Dataset" />

  <title>Filteri - Mobilni uređaji dataset</title>

  <!-- Styles & Scripts-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.0.1/air-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/air-datepicker@3.0.1/air-datepicker.min.css">

  <script src="/assets/js/jquery-3.6.0.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .search-type-text,
    .search-type-number,
    .search-type-date,
    .search-type-boolean,
    .search-type-select {
      display: none;
    }

    #data tbody tr {
      white-space: nowrap;
    }
  </style>
</head>

<body>
  <?php
  $current_page = DATATABLE;

  include 'header.php';
  ?>
  <main>
    <div class="container my-md-5 my-1">
      <p>Pretražite dataset:</p>
      <div class="row">
        <div class="col-12 col-md-6">
          <h4>Pretraži sva polja unutar dataseta:</h4>

          <form id="global_filter" action="/filters/filter.php" method="get">
            <div class="row mb-4">
              <div class="col-12 col-md-10 col-lg-8 mb-2 mb-md-0">
                <input type="text" class="form-control" name="wildcard" placeholder="Pretraži sva polja">
              </div>
              <div class="col-12 col-md-2">
                <button class="btn btn-success"><i class="bi bi-search"></i> Traži</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-12 col-md-6">
          <h4>Odaberi polje unutar dataseta te pretraži:</h4>

          <form id="attribute_filter" action="/filters/filter.php" method="get">
            <div class="row mb-2">
              <div class="col-12 col-md-10 col-lg-8 mb-2 mb-md-0">
                <select name="field" class="form-select" id="filter_select" onchange="handleFilterChange()">
                  <option>Odaberi polje za pretragu</option>
                  <option value="name" data-type="text">Naziv uređaja</option>
                  <option value="release_date" data-type="date">Datum izlaska</option>
                  <option value="width" data-type="number" data-unit="mm">Širina uređaja</option>
                  <option value="height" data-type="number" data-unit="mm">Visina uređaja</option>
                  <option value="thickness" data-type="number" data-unit="mm">Debljina uređaja</option>
                  <option value="screen_size" data-type="number" data-unit="inch">Veličina ekrana</option>
                  <option value="vertical_resolution" data-type="number" data-unit="piksel">Vertikalna rezolucija ekrana
                  </option>
                  <option value="horizontal_resolution" data-type="number" data-unit="piksel">Horizontalna rezolucija
                    ekrana
                  </option>
                  <option value="charging_port" data-type="select">Tip utora</option>
                  <option value="headphone_jack" data-type="boolean">3.5mm aux utor</option>
                  <option value="microsd" data-type="boolean">MicroSD utor</option>
                  <option value="wireless_charging" data-type="boolean">Bežično punjenje</option>
                  <option value="brand" data-type="select">Proizvođač mobitela</option>
                  <option value="processor_name" data-type="text">Naziv procesora</option>
                  <option value="processor_cores" data-type="number">Broj jezgri procesora</option>
                  <option value="processor_brand" data-type="select">Proizvođač procesora</option>
                  <option value="num_of_cameras" data-type="number">Broj kamera</option>
                  <option value="camera_description" data-type="text">Opis kamere</option>
                </select>
              </div>

              <div class="col-12 col-md-2">
                <button class="btn btn-success"><i class="bi bi-search"></i> Traži</button>
              </div>
            </div>

            <div class="row search-type-text">
              <div class="col-12 col-md-6 col-lg-4">
                <label for="value">Traži:</label>
                <input type="text" class="form-control" name="value" required disabled>
              </div>
            </div>

            <div class="row search-type-date">
              <div class="col-12 col-md-4 col-lg-3 mb-1">
                <label for="before">Nakon:</label>
                <input type="text" class="form-control" name="after" autocomplete="off" disabled>
              </div>

              <div class="col-12 col-md-4 col-lg-3 mb-1">
                <label for="after">Prije:</label>
                <input type="text" class="form-control" name="before" autocomplete="off" disabled>
              </div>
            </div>

            <div class="row search-type-number">
              <div class="col-12 col-md-4 col-lg-3 mb-1">
                <label for="gt">Više od <i class="search-type-unit"></i></label>
                <input type="number" step="0.1" class="form-control" name="gt" disabled>
              </div>

              <div class="col-12 col-md-4 col-lg-3 mb-1">
                <label for="lt">Manje od <i class="search-type-unit"></i></label>
                <input type="number" step="0.1" class="form-control" name="lt" disabled>
              </div>
            </div>

            <div class="row search-type-select">
              <div class="col-12 col-md-6 col-lg-4">
                <select class="form-select" name="value" required disabled>
                  <option selected>Odaberi...</option>
                </select>
              </div>
            </div>

            <div class="row search-type-boolean">
              <div class="col-12 col-md-6 col-lg-4">
                <input type="radio" id="yes" name="value" value="1" required disabled>
                <label for="yes">Da</label>

                <input type="radio" id="no" name="value" value="0" disabled>
                <label for="no">Ne</label>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-12 mb-4">
          <p>Preuzmi:
            <button onclick="downloadObjectAsJson(currentJSON, 'fer_2122_or_mobilni_uredaji')" class="btn btn-success"><i class="bi bi-cloud-arrow-down"></i> JSON</button>
            <button onclick="downloadCSV('fer_2122_or_mobilni_uredaji')" class="btn btn-success"><i class="bi bi-cloud-arrow-down"></i> CSV</button>
          </p>
        </div>

        <div class="col-12 table-responsive">
          <table id="data" class="table table-striped table-hover" style="width:100%">
            <thead>
              <tr>
                <th>Tvrtka</th>
                <th>Nazov</th>
                <th>Izašao</th>
                <th>Tip utora</th>
                <th>Rezolucija</th>
                <th>Vertikalna rezolucija</th>
                <th>Horizontalna rezolucija</th>
                <th>Širina</th>
                <th>Visina</th>
                <th>Debljina</th>
                <th>3.5mm Aux utor</th>
                <th>MicroSD utor</th>
                <th>Bežično punjenje</th>
                <th>Procesor</th>
                <th>Kamere</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <th>Tvrtka</th>
                <th>Nazov</th>
                <th>Izašao</th>
                <th>Tip utora</th>
                <th>Rezolucija</th>
                <th>Vertikalna rezolucija</th>
                <th>Horizontalna rezolucija</th>
                <th>Širina</th>
                <th>Visina</th>
                <th>Debljina</th>
                <th>3.5mm Aux utor</th>
                <th>MicroSD utor</th>
                <th>Bežično punjenje</th>
                <th>Procesor</th>
                <th>Kamere</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </main>

  <script>
    var currentJSON;

    /* Date picker setup */
    let locale = {
      days: ['Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota', 'Nedjelja'],
      daysShort: ['Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub', 'Ned'],
      daysMin: ['Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub', 'Ned'],
      months: ['Siječanj', 'Veljača', 'Ožujak', 'Travanj', 'Svibanj', 'Lipanj', 'Srpanj', 'Kolovoz', 'Rujan', 'Listopad', 'Studeni', 'Prosinac'],
      monthsShort: ['Siječanj', 'Veljača', 'Ožujak', 'Travanj', 'Svibanj', 'Lipanj', 'Srpanj', 'Kolovoz', 'Rujan', 'Listopad', 'Studeni', 'Prosinac'],
      today: 'Danas',
      clear: 'Očisti',
      dateFormat: 'dd.MM.yyyy',
      timeFormat: 'hh:ii',
      firstDay: 1
    };

    var beforeDatePicker = new AirDatepicker('input[name="before"]', {
      locale
    });
    var afterDatePicker = new AirDatepicker('input[name="after"]', {
      locale
    });

    /* This datepicker implementation does not listen to input field changes when someone manually types in a date */
    $("input[name='before']").on('change', function() {
      var st = $(this).val();
      var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
      var dt = new Date(st.replace(pattern, '$3-$2-$1'));

      beforeDatePicker.selectDate(dt);
    });

    $("input[name='after']").on('change', function() {
      var st = $(this).val();
      var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
      var dt = new Date(st.replace(pattern, '$3-$2-$1'));

      afterDatePicker.selectDate(dt);
    });

    var datatable;

    function renderCameras(json) {
      json = JSON.parse(unescape(json));

      let html = $("<ul></ul>")

      json.forEach(camera => {
        let subHtml = $("<ul class='list-unstyled'></ul>");

        subHtml.append($('<li></li>').text('Opis: ' + camera.description));
        subHtml.append($('<li></li>').text('Lokacija: ' + camera.position));
        subHtml.append($('<li></li>').text('Rezolucija (megapixels): ' + camera.resolution));
        subHtml.append($('<li></li>').text('Vertikalna rezolucija: ' + camera.vertical_resolution));
        subHtml.append($('<li></li>').text('Horizontalna rezolucija: ' + camera.horizontal_resolution));

        html.append(subHtml);
        html.append($("<hr>"));
      });

      Swal.fire({
        title: 'Kamere na uređaju',
        icon: 'info',
        html
      });
    }

    function renderProcessor(json) {
      json = JSON.parse(unescape(json));

      let html = $("<ul class='list-unstyled'></ul>")

      html.append($('<li></li>').text('Naziv: ' + json.name));
      html.append($('<li></li>').text('Proizvođač: ' + json.brand));
      html.append($('<li></li>').text('Broj jezrgi: ' + json.cores));
      html.append($('<li></li>').text('Brzina (gigahertz): ' + json.clock_speed));

      Swal.fire({
        title: 'Procesor',
        icon: 'info',
        html
      });
    }

    $(document).ready(function() {
      // We immediatelly load up all data
      $("#attribute_filter button").trigger('click');

      /* Datatable setup */
      datatable = $('#data').DataTable({
        searching: false,
        scrollX: true,
        language: {
          "decimal": ",",
          "emptyTable": "Nema podataka",
          "info": "Prikazujem red _START_ do _END_ od ukupno _TOTAL_ redova",
          "infoEmpty": "Ukupno 0 redova",
          "infoFiltered": "(filtrirano od _MAX_ ukupnih redova)",
          "infoPostFix": "",
          "thousands": ".",
          "lengthMenu": "Prikaži _MENU_ redova",
          "loadingRecords": "Učitavanje...",
          "processing": "Procesiranje...",
          "search": "Pretraga:",
          "zeroRecords": "Nema traženih redova",
          "paginate": {
            "first": "Prva",
            "last": "Zadnja",
            "next": "Iduća",
            "previous": "Prethodna"
          },
          "aria": {
            "sortAscending": ": aktiviraj sortiranje stupca uzlazno",
            "sortDescending": ": aktiviraj sortiranje stupca silazno"
          }
        },
        columnDefs: [{
          targets: [-1],
          data: null,
          render: function(data, type, row) {
            let cameras = data[data.length - 1];
            return "<button onclick='renderCameras(\"" + escape(JSON.stringify(cameras)) + "\")' class='btn, btn-primary btn-sm'>Detalji...</button>";
          }
        }, {
          targets: [-2],
          data: null,
          render: function(data, type, row) {
            let processor = data[data.length - 2];
            return "<button onclick='renderProcessor(\"" + escape(JSON.stringify(processor)) + "\")' class='btn, btn-primary btn-sm'>Detalji...</button>";
          }
        }]
      });
    });

    /* Generate table rows */
    function populateTable(data) {
      datatable.clear();

      if (data.length == 0) {
        datatable.draw(false);
        return;
      }

      $.each(data, function(i, item) {
        datatable.row.add([
          item.brand,
          item.name,
          item.release_date,
          item.charging_port,
          item.screen_size,
          item.vertical_resolution,
          item.horizontal_resolution,
          item.width,
          item.height,
          item.thickness,
          item.headphone_jack,
          item.microsd,
          item.wireless_charging,
          item.processor,
          item.cameras
        ]).draw(false);
      });
    }

    function disabledFilters() {
      $('.search-type-text, .search-type-number, .search-type-date, .search-type-boolean, .search-type-select').find('input, select').prop('disabled', true);
      $('.search-type-text, .search-type-number, .search-type-date, .search-type-boolean, .search-type-select').hide();
    }

    /* Choosing filter */
    function handleFilterChange() {
      // Reset input fields
      $("input[type='text'], input[type='number'], input[name='gt'], input[name='lt']").val('');
      $("input[type='radio']:checked").prop("checked", false);

      $(".search-type-unit").val('');

      var e = $("#filter_select");

      // Selected filter attribute
      var selectedFilter = e.val();

      // Data attributes
      var searchType = e.find(':selected').data('type');
      var searchUnit = e.find(':selected').data('unit');

      if (searchType == undefined) {
        disabledFilters();
        return;
      }

      if (searchType === 'select') {
        if (selectedFilter === 'charging_port') {
          $.ajax({
            method: 'get',
            url: '/filters/list.php?list=charging_port',
            beforeSend: function() {
              $('.search-type-select select').prop('disabled', true);
              $('.search-type-select select').append('<option selected>Učitavanje...</option>');
            }
          }).done(function({
            status,
            data
          }) {
            if (status == false) {
              alert('Dogodila se greška. Nije moguće filtrirati podatke.');
              return;
            }

            generateSelectOptions(data);
          }).fail(function(err) {
            console.error(err);
            alert('Dogodila se greška. Nije moguće filtrirati podatke.');
          }).always(function() {
            $('.search-type-select select').prop('disabled', false);
          });
        } else if (selectedFilter === 'brand' || selectedFilter === 'processor_brand') {
          $.ajax({
            method: 'get',
            url: '/filters/list.php?list=brand',
            beforeSend: function() {
              $('.search-type-select select').prop('disabled', true);
              $('.search-type-select select').append('<option selected>Učitavanje...</option>');
            }
          }).done(function({
            status,
            data
          }) {
            if (status == false) {
              alert('Dogodila se greška. Nije moguće filtrirati podatke.');
              return;
            }

            generateSelectOptions(data);
          }).fail(function(err) {
            console.error(err);
            alert('Dogodila se greška. Nije moguće filtrirati podatke.');
          }).always(function() {
            $('.search-type-select select').prop('disabled', false);
          });
        }
      }

      var types = {
        text: '.search-type-text',
        number: '.search-type-number',
        date: '.search-type-date',
        boolean: '.search-type-boolean',
        select: '.search-type-select',
      }

      disabledFilters();

      $(types[searchType]).find('input, select').prop('disabled', false);
      $(types[searchType]).css('display', 'flex'); // jQuery .show() sets display to block, but bootstrap 5 columns use flex

      console.log(searchUnit)

      if (searchUnit == undefined) {
        return;
      }

      $(".search-type-unit").text("(" + searchUnit + ")");
    }

    function generateSelectOptions(data) {
      // We add the default blank option so that the user must choose an option in order to proceed
      $('.search-type-select select').empty();
      $('.search-type-select select').append('<option selected>Odaberi...</option>');

      data.forEach(function({
        id,
        name
      }) {
        // We generate options based on the fetched data
        $('.search-type-select select')
          .append($("<option></option>")
            .attr("value", id)
            .text(name));
      });
    }

    // Handling the filter forms being submitted
    $("#attribute_filter").on('submit', function(e) {
      e.preventDefault();

      $.ajax({
        method: 'POST',
        url: '/filters/filter.php',
        data: $(this).serializeArray(),
        beforeSend: function() {
          $("#attribute_filter button").prop('disabled', true);
        }
      }).done(function({
        status,
        data
      }) {
        if (status == false) {
          alert('Dogodila se greška. Nije moguće filtrirati podatke.');
          return;
        }

        currentJSON = data;

        populateTable(data);
      }).fail(function(err) {
        console.error(err);
        alert('Dogodila se greška. Nije moguće filtrirati podatke.');
      }).always(function() {
        $("#attribute_filter button").prop('disabled', false);
      });
    });

    $("#global_filter").on('submit', function(e) {
      e.preventDefault();

      $.ajax({
        method: 'POST',
        url: '/filters/filter.php',
        data: $(this).serializeArray(),
        beforeSend: function() {
          $("#global_filter button").prop('disabled', true);
        }
      }).done(function({
        status,
        data
      }) {
        if (status == false) {
          alert('Dogodila se greška. Nije moguće filtrirati podatke.');
          return;
        }

        currentJSON = data;

        populateTable(data);
      }).fail(function(err) {
        console.error(err);
        alert('Dogodila se greška. Nije moguće filtrirati podatke.');
      }).always(function() {
        $("#global_filter button").prop('disabled', false);
      });
    });

    /* Download JSON data */
    function downloadObjectAsJson(exportObj, exportName) {
      var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(exportObj));
      var downloadAnchorNode = document.createElement('a');
      downloadAnchorNode.setAttribute("href", dataStr);
      downloadAnchorNode.setAttribute("download", exportName + ".json");
      document.body.appendChild(downloadAnchorNode); // required for firefox
      downloadAnchorNode.click();
      downloadAnchorNode.remove();
    }

    /* Download CSV data */
    function downloadCSV(exportName) {
      let csvData = [];

      currentJSON.forEach(row => {
        let temp = {
          ...row
        };

        // Prevent key name collisions
        temp.processor.processor_name = temp.processor.name;
        temp.processor.processor_brand = temp.processor.brand;
        delete temp.processor.name;
        delete temp.processor.brand;
        temp = {
          ...temp,
          ...temp.processor
        };
        delete temp.processor;

        if (temp.cameras == null || temp.cameras.length == 0) {
          temp = {
            ...temp,
            ...temp.cameras
          };
          delete temp.cameras;

          csvData.push({
            ...temp,
            apature: '',
            description: '',
            position: '',
            resolution: '',
            camera_horizontal_resolution: '',
            camera_vertical_resolution: ''
          });
          return;
        }

        let tempCameras = [];

        temp.cameras.forEach(camera => {
          tempCameras.push({
            ...temp,
            apature: camera.apature,
            description: camera.description,
            position: camera.position,
            resolution: camera.resolution,
            camera_horizontal_resolution: camera.horizontal_resolution,
            camera_vertical_resolution: camera.vertical_resolution,
          });
        });

        tempCameras.forEach(t => {
          delete t.cameras;
          csvData.push(t);
        });
      });

      if (csvData.length > 1) {
        csvData.unshift(Object.keys(csvData[0]));
      }

      var dataStr = "data:text/csv;charset=utf-8," + ConvertToCSV(csvData);
      var downloadAnchorNode = document.createElement('a');
      downloadAnchorNode.setAttribute("href", dataStr);
      downloadAnchorNode.setAttribute("download", exportName + ".csv");
      document.body.appendChild(downloadAnchorNode); // required for firefox
      downloadAnchorNode.click();
      downloadAnchorNode.remove();
    }

    function ConvertToCSV(objArray) {
      var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
      var str = '';

      for (var i = 0; i < array.length; i++) {
        var line = '';
        for (var index in array[i]) {
          if (line != '') line += ','

          line += array[i][index];
        }

        str += line + '\r\n';
      }

      return str;
    }
  </script>
</body>

</html>