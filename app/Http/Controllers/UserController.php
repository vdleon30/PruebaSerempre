<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->route_view = "crud_main";
        \View::share('title', "Usuarios");
        \View::share('route', "users");
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = \JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function doUserInfo(Request $request)
    {
        $data = $request->only('email');
        $user = User::where("email", $data["email"])->first();
        if ($user) {
            return response()->json(["id" => $user->id, "name" => $user->name, "email" => $user->email]);

        }
        return response()->json("Usuario No Encontrado");
    }

    public function doUserUpdate(Request $request)
    {
        $data = $request->only('email');
        $user = User::where("email", $data["email"])->first();
        if ($user) {
            $user->update([
                "name" => $request->name,
            ]);
            return response()->json("Actualizado Exitosamente");

        }
        return response()->json("Usuario No Encontrado");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \View::share('section', "index");
        $users = User::paginate(20);
        return view("{$this->route_view}", compact("users"));
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
        $validator = \Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::create([
            "name"  => $request->name,
            "email" => $request->email,
        ]);

        $password = $request->get("password");
        if ($password && !empty($password)) {
            $confirm_password = $request->get("password_confirmation");

            if ($password != $confirm_password) {
                return redirect()->back()->withErrors(["Las contraseñas no coinciden"]);
            }

            if (strlen($password) < 6) {
                return redirect()->back()->withErrors(["La contraseña debe tener al menos 6 caracteres"]);
            }

            User::where("id", $user->id)->update(["password" => Hash::make($password)]);
        }

        if (isset($request->img)) {
            $file_name = 'files/profile/' . $user->id . "/profile_img.png";
            $request->img->storeAs('', $file_name, 'uploads');
            $user->update([
                "photo" => $file_name,
            ]);
        }

        \Session::flash("success", "Creado Exitosamente");
        return redirect()->route("users.index");
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
    public function edit($id)
    {
        \View::share('section', "edit");
        \View::share('subTitle', "Editar");
        $user = User::findOrFail($id);
        return view("{$this->route_view}", compact("user"));
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
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->route("users.edit", $id)->withErrors($validator)->withInput();
        }
        $user = User::find($id);
        $user->update([
            "name"  => $request->name,
            "email" => $request->email,
        ]);

        $password = $request->get("password");
        if ($password && !empty($password)) {
            $confirm_password = $request->get("password_confirmation");

            if ($password != $confirm_password) {
                return redirect()->back()->withErrors(["Las contraseñas no coinciden"]);
            }

            if (strlen($password) < 6) {
                return redirect()->back()->withErrors(["La contraseña debe tener al menos 6 caracteres"]);
            }

            User::where("id", $user->id)->update(["password" => Hash::make($password)]);
        }

        if (isset($request->img)) {
            $file_name = 'files/profile/' . $user->id . "/profile_img.png";
            $request->img->storeAs('', $file_name, 'uploads');
            $user->update([
                "photo" => $file_name,
            ]);
        }

        \Session::flash("success", "Actualizado Exitosamente");
        return redirect()->route("users.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario Eliminado Exitosamente');
    }

    public function getSetPassword($user)
    {

        return view("complete_register", compact("user"));
    }

    public function postSetPassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        User::where("id", $request->id)->update(["password" => Hash::make($request->password)]);

        return redirect("/");
    }
}
