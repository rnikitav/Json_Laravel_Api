<?php


namespace App\Services;


use App\Events\UserDeleteEvent;
use App\Http\Requests\CreateUserJsonRequest;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\DB;

class UserService
{
    public $user = null;
    protected array $separatedColumns = ['town'];

    /**
     * Create User in DB
     */
    public function createUser(CreateUserJsonRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $user = User::create($data);
            if ($this->validationToCreateASeparateTable($request)) {
                $this->createUserDetails('town', $request->input('town'), $user->id);
            }
            $this->user = $user;
        }, 2);
        return $this->user;
    }

    public function updateUser(CreateUserJsonRequest $request, $id)
    {
        $user = User::find($id);
        if (!isset($user)) {
            return response()->json(['data' => 'failed', 'error' => 'User not found']);
        }
        $user->update($request->validated());

        if ($this->validationToCreateASeparateTable($request)) {
            $userDetails = $user->details()->first();
            if ($userDetails) {
                $userDetails->update($request->validated());
            } else {
                $this->createUserDetails('town', $request->input('town'), $user->id);
            }
        }
        return $user;
    }

    /**
     * Delete user from two tables(if exist)
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!isset($user)) {
            return response()->json(['Delete' => 'failed', 'error' => 'User not found']);
        }
        event(new UserDeleteEvent($user));
        return response()->json(['Delete' => 'Success']);
    }

    protected function createUserDetails($column, $data, $userId)
    {
        return UserDetails::create([$column => $data, 'user_id' => $userId]);
    }

    protected function validationToCreateASeparateTable(CreateUserJsonRequest $request): bool
    {
        return $request->hasAny($this->separatedColumns);
    }


}
