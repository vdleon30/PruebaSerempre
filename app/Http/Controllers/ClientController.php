<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Exports\ClientsExport;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->route_view = "crud_main";
        \View::share('title', "Clientes");
        \View::share('route', "clients");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($filter = false)
    {
        \View::share('section', "index");
        \View::share('filter', $filter);
        $clients = Client::fcity($filter)->paginate(20);
        \View::share("cities", City::orderBy("name","ASC")->get());
        return view("{$this->route_view}", compact("clients"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        \View::share('section', "create");
        \View::share('subTitle', "Crear");
        \View::share("cities", City::orderBy("name","ASC")->get());
        return view("{$this->route_view}");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'cod'     => 'required|string|max:6|unique:clients',
            'city_id' => 'required|string|max:6|exists:cities,id,id,' . $request->city_id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Client::create([
            "name"    => $request->name,
            "cod"     => $request->cod,
            "city_id" => $request->city_id,
        ]);
        \Session::flash("success", "Creado Exitosamente");
        return redirect()->route("clients.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        \View::share('section', "edit");
        \View::share('subTitle', "Editar");
        \View::share("cities", City::orderBy("name","ASC")->get());
        return view("{$this->route_view}", compact("client"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'cod'     => 'required|string|max:6|unique:clients,cod,' . $id,
            'city_id' => 'required|string|max:6|exists:cities,id,id,' . $request->city_id,
        ]);

        if ($validator->fails()) {
            return redirect()->route("clients.edit", $id)->withErrors($validator)->withInput();
        }
        $client = Client::find($id);
        $client->update([
            "name"    => $request->name,
            "cod"     => $request->cod,
            "city_id" => $request->city_id,
        ]);
        \Session::flash("success", "Actualizado Exitosamente");
        return redirect()->route("clients.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente Eliminado Exitosamente');
    }

    public function exportExcel()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        return Excel::download(new ClientsExport(), 'Clientes.xlsx');
    }

    public function importExcel()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        Excel::import(new ClientsImport(), request()->file('file'));
        return back();
    }
}
