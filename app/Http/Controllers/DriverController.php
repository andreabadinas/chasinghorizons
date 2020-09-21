<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\Driver;

class DriverController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   //view('drivers.index')->with('drivers', $drivers)
 
        // $drivers = User::whereHas(
        //     'roles', function($q){
        //         $q->where('name', 'staff');
        //     }
        // )->get();
        
        // $drivers->join('drivers' , 'drivers.user_id', 'user_id')
        // ->get();
        //view('schedule')->with('drivers', $drivers);
        
        $drivers = User::whereHas('roles',function($q){
            $q->where('name', 'staff');
        })->get();

        // $drivers=  DB::table('users')
        // ->join('drivers', 'drivers.user_id', 'users.id')
        // ->get();
   
        return view('drivers.index')->with('drivers', $drivers);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $details = new Driver();
        $details->birthdate= request('birthdate');
        $details->age    = request('age');
        $details->address= request('address');
        $details->license= request('license');
        $details->contact= request('contact');
        $details->gender = request('gender');
        
         $user = User::findOrFail(request('user_id'));

         if($user->details()->save($details)){
           
            $request->session()->flash('success', $user->name . '  s details has been updated.');
        }else{
            $request->session()->flash('error', 'Error in updating');
        }

         return redirect()->route('drivers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
    //    return view('drivers.details')->with('details', $details);
    //    $user = User::findOrFail($id);
           
     
        $driver = DB::table('drivers')  
        ->where('user_id', $id)
        ->get();
        if(count($driver)>0){
            $user = DB::table('users')
            ->where('id', $driver[0]->user_id)
            ->get();
        
    
            return view('drivers.details')->with([
            'driver' => $driver,
            'user'    => $user
            
            ]);
        }

        $user = User::findOrFail($id);

        return view('drivers.create')->with([
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $driver = Driver::findOrFail($id);
        // return view('drivers.edit', [
        //     'driver' => $driver
        // ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {  
        

        $driver = Driver::findOrFail($id);
        $driver->age= request('age');
        $driver->birthdate= request('birthdate');        
        $driver->gender= request('gender');
        $driver->contact= request('contact');
        $driver->license= request('license');
        $driver->address= request('address');

        if($driver->save()){
            $user = DB::table('users')
            ->where('id', $driver->user_id)
            ->get();
            $request->session()->flash('success', $user[0]->name . '  s datails has been updated.');
        }else{
            $request->session()->flash('error', 'Error in updating');
        }
        
        return redirect()->route('drivers.show', $driver->user_id); 
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
       $user = User::find($id);

       $user->roles()->detach();

       $user->details->delete();

        if($user->delete()){
            $request->session()->flash('success', 'deletion successful');
        }else{
            $request->session()->flash('error', 'Error in deleting' . $driver->name);
        }

        return redirect()->route('drivers.index');

    }

}
