<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // Form edit profile sendiri
    public function edit()
    {
        $user = Auth::user();
        return view('operator.users.edit', compact('user'));
    }

    // Update profile sendiri
   public function update(Request $request)
{
    $authId = Auth::id();
    $user = User::findOrFail($authId);

    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'new_password' => 'nullable|string|min:4',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->new_password) {
        $user->password = Hash::make($request->new_password);
    }

    $user->save();

   return redirect()
    ->route('operator.users.edit')
    ->with('success', 'Data berhasil diupdate'
        . ($request->new_password ? '. Password baru: '.$request->new_password : '')
    );
}
}