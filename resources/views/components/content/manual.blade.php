<x-adminlte-card title="User Manual" theme="muted" icon="" collapsible="collapsed" removable maximizable>
    @php
        $heads = [
            'เรื่อง','เอกสาร'
        ];

        $config = [
            'data' => $tableData,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
        ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach($config['data'] as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{!! $cell !!}</td>
                @endforeach
            </tr>
        @endforeach
    </x-adminlte-datatable>
</x-adminlte-card>
