<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- JSZip (required for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- DataTables Buttons CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" />
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<!-- Initialize all DataTables with export buttons -->
<script>
  $(document).ready(function () {
    const tables = [
      'paysTable', 'regionTable', 'departementTable', 'villeTable', 'datatable',
      'reservationTable', 'passagerTable', 'autocarTable', 'typeAutocarTable',
      'emplacementTable', 'hotelTable', 'voyageTable', 'programmationTable',
      'pointdepartTable'
    ];

    tables.forEach(function(id) {
      if ($('#' + id).length) {  // Only initialize if table exists on the page
        $('#' + id).DataTable({
          language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
          },
          dom: 'Bfrtip',  // Show buttons on top
          buttons: [
            'copy', 'csv', 'excelHtml5', 'pdfHtml5'
          ]
        });
      }
    });
  });
</script>
