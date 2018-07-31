<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\View;
use Session;
use Hash;

class AdminController extends Controller
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
        return view('Admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //show the create user view
        return view('admins.create');
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
        $admin = new Admin;
        //add data to new object
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        //save the new added data to the object to the database
        $admin->save(); 
        //flash message to tell admin has been successfully added to database
        Session::flash('success', 'Admin successfully added!');
        //redirect to create new admin page
        return redirect()->route('admins.show', $admin->id);
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
        $admin = Admin::find($id);
        return view('admins.show')->withAdmin($admin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('admins.edit')->withAdmin($admin);
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
        $admin = Admin::find($id);
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->save();
        //redirect and flash success
        Session::flash('success', 'Admin details updated successfully!');
        return redirect()->route('admin.admins', $admin->$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::find($id);
        $admin->delete();
        Session::flash('success', 'Admin successfully deleted!');
        return redirect()->route('admin.admins');
    }
} 