ajax_request_{{$chartName}}();

function ajax_request_{{$chartName}}(){
    $.ajax({
        url: "/dashboard/{{$chartName}}",
        type: 'POST',
        dataType: 'json',
        data:{'startdate':startdate, 'enddate':enddate, 'showtype':showtype},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            chart_{{$chartName}}.data = {
                {{ $slot }}
            };
            chart_{{$chartName}}.update();
            console.log(data);
        },
        error: function(data){
            console.log(data);
        }
    });
};
