<table style="border: black">
    @foreach($collection->groupBy('account_id') as $factor)
        <tr>
            <td rowspan="{{ count($factor)+1 }}">{{ $factor[0]['account_id'] }}</td>
            @foreach($factor as $item)
                <td>{{ $item['product'] }}</td>
            @endforeach
        </tr>
    @endforeach
</table>