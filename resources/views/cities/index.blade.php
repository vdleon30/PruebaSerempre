<div class="justify-end mb-3 text-right">
    <a href="{{ route('cities.create') }}" class="btn btn-success">
        Crear
    </a>
</div>
<x-auth-session-success class="mb-4" :success="session('success')" />
<div class="table-responsive">
    <table class="table text-center table-hover border border-gray-800 table-auto">
        <thead class="bg-blue-300 thead-dark">
            <tr>
                <th class="">
                    Código
                </th>
                <th class="">
                    Ciudad
                </th>
                <th class="">
                    Creado
                </th>
                <th class="text-center">
                    <div class="text-center">
                        <svg class="h-5 w-5 m-auto" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" fill-rule="evenodd">
                            </path>
                        </svg>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cities as $city)
            <tr>
                <td>
                    <span class="my-auto ml-4">
                        {{$city->cod}}
                    </span>
                </td>
                <td>
                    <span class="my-auto ml-4">
                        {{$city->name}}
                    </span>
                </td>
                <td class="">
                    {!!\DateTime::createFromFormat("Y-m-d H:i:s", date('Y-m-d H:i:s', strtotime($city->created_at)))->format("Y-m-d H:i")  !!}
                </td>
                <td>
                    <div class="d-inline-flex">
                        <a href="{{ route('cities.edit',$city->id) }}">
                            <svg class="h-6 w-6 text-info mx-2" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                </path>
                            </svg>
                        </a>
                        <form action="{{ route('cities.destroy',$city->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="">
                                <svg class="h-6 w-6 text-danger" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{$cities->links()}}

<script type="text/javascript">
    
</script>
