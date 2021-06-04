<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function __construct()
    {
        $this->route_view = "crud_main";
        \View::share('title', "Ciudades");
        \View::share('route', "cities");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \View::share('section', "index");
        $cities = City::paginate(20);
        return view("{$this->route_view}", compact("cities"));
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
        $request->cod = strtoupper($request->cod);
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cod'  => 'required|string|max:6|unique:cities',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        City::create([
            "name" => $request->name,
            "cod"  => strtoupper($request->cod),
        ]);
        \Session::flash("success", "Creado Exitosamente");
        return redirect()->route("cities.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        \View::share('section', "edit");
        \View::share('subTitle', "Editar");
        return view("{$this->route_view}", compact("city"));
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
        $request->cod = strtoupper($request->cod);
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cod'  => 'required|string|max:6|unique:cities,cod,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $city = City::find($id);
        $city->update([
            "name" => $request->name,
            "cod"  => strtoupper($request->cod),
        ]);
        \Session::flash("success", "Actualizado Exitosamente");
        return redirect()->route("cities.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('cities.index')->with('success', 'Ciudad Eliminado Exitosamente');
    }
}
