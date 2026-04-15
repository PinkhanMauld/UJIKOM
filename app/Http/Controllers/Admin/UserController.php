<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'admin')->get();
        return view('admin.users.index', compact('users'));
    }

    public function operatorIndex()
{
    $users = User::where('role', 'operator')->latest()->get();
    return view('admin.users.operatorIndex', compact('users'));
}


    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|in:admin,operator',
        ]);

        $number = User::count() + 1;
        $passwordPlain = substr($request->email, 0, 4) . $number;

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($passwordPlain),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dibuat. Password: ' . $passwordPlain);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'new_password' => 'nullable|string|min:4',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->new_password) {
            $data['password'] = Hash::make($request->new_password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

   public function destroy($id)
{
    $userId = Auth::id();

    if ($userId == $id) {
        return back()->with('error', 'Tidak bisa hapus akun sendiri.');
    }

    User::findOrFail($id)->delete();

    return back()->with('success', 'User berhasil dihapus.');
}
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $passwordPlain = substr($user->email, 0, 4) . $user->id;

        $user->update([
            'password' => Hash::make($passwordPlain)
        ]);

        return back()->with('success', 'Password baru: ' . $passwordPlain);
    }

    public function show(string $id)
    {
        //
    }

    public function exportAdmin()
{
    return Excel::download(new UsersExport('admin'), 'users-admin.xlsx');
}

public function exportOperator()
{
    return Excel::download(new UsersExport('operator'), 'users-operator.xlsx');
}
}