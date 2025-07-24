var ctx_{{$chartName}} = document.getElementById('{{$chartName}}').getContext('2d');
var chart_{{$chartName}} = new Chart(ctx_{{$chartName}}, {
    type: 'bar',
    data: {},
    options: {
        {{ $slot }}
    }
});
