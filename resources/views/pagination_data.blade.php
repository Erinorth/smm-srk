@foreach($data as $row)
      <tr>
       <td>{{ $row->id}}</td>
       <td>{{ $row->ConsumableCode }}</td>
       <td>{{ $row->PurchaseCode }}</td>
      </tr>
      @endforeach
      <tr>
       <td colspan="3" align="center">
        {!! $data->links() !!}
       </td>
      </tr>