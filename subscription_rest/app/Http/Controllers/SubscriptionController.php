<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $validateData = $request->validate([
            'website_id' => 'int|required|exists:websites,id',
            'user_id' => 'int|required|exists:users,id'
        ]);

        try {
            DB::beginTransaction();

            $subscription = Subscription::create($validateData);

            DB::commit();

            return $this->success($subscription, 'Subscription created successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('SubscriptionController | subscribe | error : ', [$e->getMessage()]);
            
            return $this->failed($e->getMessage());
        }
    }

    public function unsubscribe($id)
    {
        try {
            DB::beginTransaction();

            $subscription = Subscription::findOrFail($id);
            $subscription->delete();

            DB::commit();

            return $this->success(null, 'Subscription unsubscribe successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('SubscriptionController | delete | error : ', [$e->getMessage()]);
            
            return $this->failed('Subscription unsubscribe failed');
        }
    }
}
