<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function collection()
    {
        return User::where('role', $this->role)->get()->map(function ($user) {

            $defaultPassword = substr($user->email, 0, 4) . $user->id;

            return [
                'name'     => $user->name,
                'email'    => $user->email,
                'password' => Hash::check($defaultPassword, $user->password)
                                    ? $defaultPassword
                                    : 'This account already edited the password',
            ];
        });
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Password'];
    }
}