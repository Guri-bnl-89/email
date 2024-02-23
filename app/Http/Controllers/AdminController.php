<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
 
    // List users
    public function usersList()
    {
        if(auth()->user()->access == 'admin'){
            $users = User::where('id', '!=', 1)->where('status', '!=', 'deleted')->get();      
            return view('pages.user_management')->with(compact('users'));
        } else {
            return view('pages.error');
        }
    }

    public function userUpdate(Request $request)
    {
        if(auth()->user()->access == 'admin'){
            try{            
                $request->validate([
                    'uid' => 'required',
                    'credits' => 'required',
                    'role' => 'required',
                    'status' => 'required',
                ]);
                $user = User::find($request->uid);
                $user->credits = $request->credits;
                $user->access = $request->role;
                $user->status = $request->status;            
                $user->save();

                return redirect()->back()->with('success', 'User profile updated successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            return view('pages.error');
        }

    }

    public function deleteUser($id)
    {
        if(auth()->user()->access == 'admin'){
            try{
                $user = User::find($id);
                $user->status = 'deleted';            
                if($user->save()){
                    return redirect()->back()->with('success', 'User deleted successfully.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }  
        } else {
            return view('pages.error');
        }      
    }

}
