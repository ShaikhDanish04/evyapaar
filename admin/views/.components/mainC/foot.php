
   <!-- Core plugin JavaScript-->
   <script src="<?php echo $addr_space ?>views/.assets/vendor/jquery-easing/jquery.easing.min.js"></script>

   <!-- Custom scripts for all pages-->
   <script src="<?php echo $addr_space ?>views/.assets/js/sb-admin-2.min.js"></script>

   <!-- Page level plugins -->
   <script src="<?php echo $addr_space ?>views/.assets/vendor/chart.js/Chart.min.js"></script>


   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css" />

   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>

   <script>
      $(document).ready(function() {
         // $('.data-table').DataTable();

         var table = $('.data-table').DataTable({
            dom: 'Bfrtip',
            colReorder: true,
            fixedHeader: true,
            // responsive: true,
            // keys: true,
            buttons: [{
                  extend: 'colvis',
                  className: 'btn btn-primary btn-sm',
                  init: function(api, node, config) {
                     $(node).removeClass('btn-secondary')
                  }
               },
               {
                  extend: 'pageLength',
                  className: 'btn btn-primary btn-sm',
                  init: function(api, node, config) {
                     $(node).removeClass('btn-secondary')
                  }
               },
               {
                  extend: 'copyHtml5',
                  exportOptions: {
                     columns: ':visible'
                  },
                  className: 'btn btn-dark btn-sm',
                  init: function(api, node, config) {
                     $(node).removeClass('btn-secondary')
                  }
               },
               {
                  extend: 'excelHtml5',
                  exportOptions: {
                     columns: ':visible'
                  },
                  className: 'btn btn-success btn-sm',
                  init: function(api, node, config) {
                     $(node).removeClass('btn-secondary')
                  }
               },
               {
                  extend: 'csvHtml5',
                  exportOptions: {
                     columns: ':visible'
                  },
                  className: 'btn btn-info btn-sm',
                  init: function(api, node, config) {
                     $(node).removeClass('btn-secondary')
                  }
               },
               {
                  extend: 'pdfHtml5',
                  exportOptions: {
                     columns: ':visible'
                  },
                  className: 'btn btn-danger btn-sm',
                  init: function(api, node, config) {
                     $(node).removeClass('btn-secondary')
                  },
               }, {
                  extend: 'print',
                  className: 'btn-sm',
                  exportOptions: {
                     columns: ':visible'
                  }
               }
            ],
            initComplete: function() {
               this.api().columns().every(function() {
                  var column = this;
                  var select = $('<select class="form-control form-control-sm"><option value="-- Select --"></option></select>')
                     .appendTo($(column.footer()).empty())
                     .on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex(
                           $(this).val()
                        );

                        column
                           .search(val ? '^' + val + '$' : '', true, false)
                           .draw();
                     });

                  column.data().unique().sort().each(function(d, j) {
                     if (/^[a-zA-Z0-9- ]*$/.test(d) == true) {
                        select.append('<option  value="' + d + '">' + d + '</option>')
                        // alert('Your search string contains illegal characters.');
                     }
                  });
               });

               console.log($('.data-table').fadeIn());

               $('.dt-buttons').removeClass('btn-group')
            }
         });



      });
   </script>