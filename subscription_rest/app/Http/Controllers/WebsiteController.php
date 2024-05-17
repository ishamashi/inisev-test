<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebsiteController extends Controller
{
    public function create(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'url' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $website = Website::create($validateData);

            DB::commit();

            return $this->success($website, 'Website created successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('WebsiteController | create | error : ', [$e->getMessage()]);
            
            return $this->failed('Website created failed');
        }
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'sometimes',
            'url' => 'sometimes'
        ]);

        try {
            DB::beginTransaction();

            $website = Website::findOrFail($id);
            $website->update($validateData);

            DB::commit();

            return $this->success($website, 'Website updated successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('WebsiteController | update | error : ', [$e->getMessage()]);
            
            return $this->failed('Website updated failed');
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $website = Website::findOrFail($id);
            $website->delete();

            DB::commit();

            return $this->success(null, 'Website deleted successfully');
        } catch(Exception $e) {
            DB::rollBack();

            Log::error('WebsiteController | delete | error : ', [$e->getMessage()]);
            
            return $this->failed('Website deleted failed');
        }
    }
}
