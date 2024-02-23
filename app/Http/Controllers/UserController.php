<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function profile()
    {
        $user = auth()->user();
        return view('pages.user_profile')->with(compact('user'));
    }

    public function profileEdit(Request $request)
    {
        try{
            $user = auth()->user();
            if(isset($request->user_edit) && $request->user_edit == 1){
                $request->validate([
                    'name' => 'required|string|max:191',
                    'country' => 'required',
                    'address' => 'required',
                    'phone' => 'required|string|max:20',
                    'email' => 'required|string|email|max:191|unique:users,email,' . auth()->id(),
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                $user->name = $request->name;
                $user->surname = $request->surname;
                $user->country = $request->country;
                $user->address = $request->address;
                $user->phone = $request->phone;    
                $user->email = $request->email; 

                // Update the image if provided
                if ($request->hasFile('image')) {
                    // Store the new image in the filesystem
                    $imagePath = $request->file('image')->store('images', 'web_public');

                    // Delete the old image if it exists
                    if ($user->image) {
                        Storage::disk('web_public')->delete($user->image);
                    }

                    // Update the user's image_path in the database
                    $user->image = $imagePath; 
                }

                $message = "Your profile updated successfully.";           
            } else {
                // Check if the provided current password matches the hashed password stored in the database
                if (!Hash::check($request->current_password, $user->password)) {
                    return redirect()->back()->withErrors(['current_password' => 'The provided current password is incorrect.'])->withInput();
                }
                $request->validate([
                    'current_password' => 'required',
                    'new_password' => 'required|string|min:8|confirmed',
                ]);
                
                $user->password = Hash::make($request->new_password);

                $message = "Your password has been changed successfully.";
            }
            $user->save();

            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    //
    public function logout () {
        //logout user
        auth()->logout();
        // redirect to homepage
        return redirect('/');
    }

    
}
