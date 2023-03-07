<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth()->user()->user_type == 'superadmin')
            $users = User::all();
        else
            $users = User::where('company_id', Auth()->user()->company_id)->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = null;
        $clients = Clients::all();
        return view('users.edit', compact('user', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'user_client' => 'required',
                'user_type' => 'required',
                'user_name' => 'required',
                'user_email' => 'required|email|unique:users,email',

            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'user_email.required' => 'Please provide user email',
                'user_email.email' => 'invalid Email',
            ]
        );
        $user = new User();
        $user->company_id = $request->user_client;
        $user->user_type = $request->user_type;
        $user->name = $request->user_name;
        $user->email = $request->user_email;
        $user->password = bcrypt('123456');
        $user->save();
        return redirect()->route('users.index');
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
        $user = User::find($id);
        $clients = Clients::all();
        return view('users.edit', compact('user', 'clients'));
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
        $this->validate(
            $request,
            [
                'user_client' => 'required',
                'user_type' => 'required',
                'user_name' => 'required',
                'user_email' => 'required|email|unique:users,email,' . $id,

            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'user_email.required' => 'Please provide user email',
                'user_email.email' => 'invalid Email',
            ]
        );
        $user =  User::find($id);
        $user->company_id = $request->user_client;
        $user->user_type = $request->user_type;
        $user->name = $request->user_name;
        $user->email = $request->user_email;
        $user->save();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function changePassword($id)
    {
        return view('users.changePassword', compact('id'));
    }
    public function storeNewPass(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'old_password' => 'required',
                'new_password' => 'required|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'required',

            ],
            $messages = [
                'required' => 'The :attribute field is required.'
            ]
        );
        $user = User::find($id);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            return redirect()->route('users.index');
        } else {

            // error with message to old_password
            return back()
                ->withInput()
                ->withErrors(['old_password'=>'Old password is incorrect']);
            // return redirect()->back()->with('error', 'Old password is incorrect');
        }
    }
}
