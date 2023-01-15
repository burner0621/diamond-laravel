<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return view('backend.users.list', [
            'users' => User::orderBy('id', 'DESC')->paginate(10),
            'title' => 'All Users'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customers()
    {
       
        return view('backend.users.list', [
            'users' => User::where('role', 0)->paginate(10),
            'title' => 'Customers'
        ]);
    }

    public function get()
    {
        return datatables()->of(User::query())
        ->editColumn('role', function($row) {
            if($row->role == 0)
            {
                return "<span class='badge badge-secondary'> Customer </span>";   
            }
            elseif($row->role == 1)
            {
                return "<span class='badge badge-primary'> Admin </span>";   
            }
            elseif($row->role == 3)
            {
                return "<span class='badge badge-info'> Seller </span>";   
            }
            
        })
        ->addIndexColumn()
        ->addColumn('action', function($row){

               
               $btn = '<a href="'.route('backend.users.edit', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
               $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';

                return $btn;
        })
        ->rawColumns(['action', 'role'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view('backend.users.edit', [
            'user' => User::findOrFail($id)
        ]);
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
        $user = User::findOrFail($id);
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required'],
        ]);
        
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->email_verified_at = ($request->email_verified_at == 1) ? date('Y-m-d h:i:s') : null;
        $user->role = $request->role;
        if($request->password)
        {
            $user->password = Hash::make($request->password);
        }
        $user->update();

        return redirect()->route('backend.users.edit', $user->id)->with('success','User updated');
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
}
