$('#data_table{{$tableName}}').DataTable({
    processing: true,
    serverSide: true,
    ajax:{
        url: "{{$ajaxUrl}}/{{$ajaxUrl2}}",
    },
    columns: [
        {{$slot}}
    ],
    "order":[{{$order}}],
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
    "dom": "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-6'B><'col-sm-12 col-md-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    "buttons": ["copy", "excel", "print", "colvis"]
});
