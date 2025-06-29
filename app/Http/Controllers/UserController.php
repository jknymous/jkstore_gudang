<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'gudang')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'no_hp' => 'nullable|string|max:20',
                'password' => 'required|string|min:6|confirmed',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
                'role' => 'gudang'
            ]);

            return redirect()->route('users.index')->with('success', 'User gudang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Gagal menambahkan user.');
        }
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => "required|email|unique:users,email,{$user->id}",
                'no_hp' => 'nullable|string|max:20',
                'password' => 'nullable|confirmed|min:6',
            ]);

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->no_hp = $validated['no_hp'] ?? null;

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Gagal mengupdate user.');
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Gagal menghapus user.');
        }
    }
}
