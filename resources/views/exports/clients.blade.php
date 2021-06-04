<table>
    <thead>
    <tr>
        <th style="text-align:center;width: 30px">Cod</th>
        <th style="text-align:center;width: 30px">Name</th>
        <th style="text-align:center;width: 30px">Ciudad</th>
        <th style="text-align:center;width: 30px">Registrado</th>
    </tr>
    </thead>
    <tbody>
    @foreach($clients as $client)
        <tr>
            <td style="text-align:center;width: 30px">{{ $client->cod }}</td>
            <td style="text-align:center;width: 30px">{{ $client->name }}</td>
            <td style="text-align:center;width: 30px">{{ $client->city?$client->city->name:"No Registrado" }}</td>
            <td style="text-align:center;width: 30px">{{\DateTime::createFromFormat("Y-m-d H:i:s", $client->created_at)->format("Y-m-d H:i:s")}}</td>
        </tr>
    @endforeach
    </tbody>
</table>