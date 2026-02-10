<?php
namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
public function store(Request $request)
{
    $this->authorize('create', User::class);


    $data = $request->validate([
    'name' => 'required|string',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:8',
    'role' => 'in:admin,member'
    ]);


    $data['tenant_id'] = auth()->user()->tenant_id;
    $data['password'] = Hash::make($data['password']);

return User::create($data);
}


public function destroy(User $user)
{
    $this->authorize('delete', $user);
    $user->delete();
return response()->noContent();
}
}