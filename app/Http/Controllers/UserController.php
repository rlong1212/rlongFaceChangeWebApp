<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\View;
use Session;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('viewEditUsers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //show the create user view
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //using php as user may not have javascript turned on
        //validate form data
        $this->validate($request, array(
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ));
        //send new user data from form to database
        //create instance of User model
        $user = new User;
        //add data to new object
        $user->name = $request->name;
        $user->email = $request->email;
        //hash password
        $user->password = Hash::make($request->password);
        //save the new added data to the object to the database
        $user->save(); 
        //flash message to tell user has been successfully added to database
        Session::flash('success', 'User successfully added!');
        //redirect to create new user page
        return redirect()->route('users.show', $user->id); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //to allow user to view /edit etc their created user
        $user = User::find($id);
        return view('users.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //find user in database
        $user = User::find($id);
        //return view of user
        return view('users.edit')->withUser($user);
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
        //validate inputted data
        $this->validate($request, array(
            'name' => 'required|max:50',
            'email' => 'required|email'
        ));
        //save into database
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        //redirect and flash success
        Session::flash('success', 'User details updated successfully!');
        return redirect()->route('users.show', $user->$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find user in database
        $user = User::find($id);
        //delete method
        $user->delete();
        //flash message success
        Session::flash('success', 'User successfully deleted!');
        //redirect to see users
        return redirect()->route('admin.users');
    }
}
