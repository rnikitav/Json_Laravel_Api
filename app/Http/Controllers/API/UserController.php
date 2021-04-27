<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserJsonRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{

    //GET http://test/api/v1/users     get all users
    public function index()
    {
        return User::with('details')->paginate();
    }

    // POST http://test/api/v1/users  store user
    public function store(CreateUserJsonRequest $request)
    {
        return (new UserService())->createUser($request);
    }

    // GET http://test/api/v1/users/{$id}    show user by id
    public function show($id)
    {
        return User::findOrFail($id)->load('details');
    }

    // PUT / PATCH http://test/api/v1/users/{user}  update user by id
    // PUT method requires all fields
    // PATCH method changing only incoming fields
    public function update(CreateUserJsonRequest $request, $id)
    {
        return (new UserService())->updateUser($request, $id);
    }

    // DELETE  http://test/api/v1/users/{user}  delete user by id
    public function destroy($id)
    {
        return (new UserService())->deleteUser($id);
    }
}
