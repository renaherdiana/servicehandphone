<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /** 🔹 Tampilkan daftar pengguna */
    public function index()
    {
        $users = User::latest()->get();
        return view('page.user.index', compact('users'));
    }

    /** 🔹 Form tambah pengguna */
    public function create()
    {
        return view('page.user.create');
    }

    /** 🔹 Simpan pengguna baru */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'alamat'    => 'nullable|string|max:255',
            'no_telp'   => 'nullable|string|max:20',
            'status'    => 'required|in:active,inactive',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);
        $user->alamat   = $request->alamat;
        $user->no_telp  = $request->no_telp;
        $user->status   = $request->status;

        // 🖼️ Simpan foto ke storage/public/users
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('users', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /** 🔹 Detail pengguna */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('page.user.show', compact('user'));
    }

    /** 🔹 Form edit pengguna */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('page.user.edit', compact('user'));
    }

    /** 🔹 Update data pengguna */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'alamat'    => 'nullable|string|max:255',
            'no_telp'   => 'nullable|string|max:20',
            'status'    => 'required|in:active,inactive',
            'password'  => 'nullable|min:6',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->alamat  = $request->alamat;
        $user->no_telp = $request->no_telp;
        $user->status  = $request->status;

        // 🔑 Ganti password kalau diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 🖼️ Ganti foto jika ada upload baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }

            $path = $request->file('foto')->store('users', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /** 🔹 Hapus pengguna */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // 🗑️ Hapus foto dari storage
        if ($user->foto && Storage::exists('public/' . $user->foto)) {
            Storage::delete('public/' . $user->foto);
        }

        $user->delete();

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil dihapus.');
    }
}
