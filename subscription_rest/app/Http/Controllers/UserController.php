<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email'
        ]);

        try {
            DB::beginTransaction();

            $user = User::create($validateData);

            DB::commit();

            return $this->success($user, 'User created successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('UserController | create | error : ', [$e->getMessage()]);
            
            return $this->failed($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'sometimes',
            'email' => 'sometimes|email|unique:users,email,'.$id
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->update($validateData);

            DB::commit();

            return $this->success($user, 'User updated successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('UserController | update | error : ', [$e->getMessage()]);
            
            return $this->failed('User updated failed');
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();

            return $this->success(null, 'User deleted successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('UserController | delete | error : ', [$e->getMessage()]);
            
            return $this->failed('User deleted failed');
        }
    }
}
