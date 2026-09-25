<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class NormalUserController extends Controller
{
    private function authorizeAdministrator()
    {
        if (! request()->user() || request()->user()->role !== 'administrator') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index(Request $request)
    {
        $this->authorizeAdministrator();

        $query = User::where('role', 'user');

        if ($request->has('search') && ! empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('normal_users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeAdministrator();
        $companies = Company::where('is_active', true)->orderBy('name')->get();

        return view('normal_users.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdministrator();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'company' => ['required', 'string', 'exists:companies,name'],
            'department' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'company' => $request->company,
            'department' => $request->department,
            'phone' => $request->phone,
        ]);

        return redirect()->route('normal_users.index')->with('success', 'สร้างบัญชีผู้ใช้งานทั่วไปเรียบร้อยแล้ว');
    }

    public function edit(User $normal_user)
    {
        $this->authorizeAdministrator();
        if ($normal_user->role !== 'user') {
            abort(404);
        }

        $companies = Company::where('is_active', true)->orderBy('name')->get();

        return view('normal_users.edit', compact('normal_user', 'companies'));
    }

    public function update(Request $request, User $normal_user)
    {
        $this->authorizeAdministrator();
        if ($normal_user->role !== 'user') {
            abort(404);
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($normal_user->id)],
            'company' => ['required', 'string', 'exists:companies,name'],
            'department' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        $request->validate($rules);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'department' => $request->department,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $normal_user->update($updateData);

        return redirect()->route('normal_users.index')->with('success', 'อัปเดตข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function destroy(User $normal_user)
    {
        $this->authorizeAdministrator();
        if ($normal_user->role !== 'user') {
            abort(404);
        }

        $normal_user->delete();

        return redirect()->route('normal_users.index')->with('success', 'ลบบัญชีผู้ใช้งานเรียบร้อยแล้ว');
    }
}
