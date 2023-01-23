
<style>
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    #customers td, #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }
    
    #customers tr:nth-child(even){background-color: #f2f2f2;}
    
    #customers tr:hover {background-color: #ddd;}
    
    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }
    </style>
    
    <table id="customers">
      <tr>
        <th>Sale ID</th>
        <th>Product</th>
        <th>Employee</th>
        <th>Date</th>
      </tr>
      @foreach ($results as $sale)
      <tr class="hover:bg-blue-300 {{ ($loop->even ) ? " bg-blue-100" : "" }}">
        <td class="px-3 py-2">{{ $sale->id }}</td>
        <td class="px-3 py-2 capitalize">{{ $sale->product->name }}</td>
        <td class="px-3 py-2 capitalize">{{ $sale->employee->user->name }}</td>
        <td class="px-
        3 py-2">{{ $sale->created_at }}</td>

    </tr>
    @endforeach
  </table>    