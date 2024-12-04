<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\PreRegistration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PreRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createOrUpdatePreRegistration(Request $request)
    {
     
        $validatedData = $request->validate([
            'event_id' => 'required|exists:events,id',
            'qr_code' => 'nullable|string',
        ]);

        
        $existingPreRegistration = PreRegistration::where('event_id', $validatedData['event_id'])
                                                    ->where('user_id', $request->user()->id)
                                                    ->first();

        
        DB::beginTransaction();

        try {
            if ($existingPreRegistration) {
              
                $existingPreRegistration->update($validatedData);
                $message = 'Pre-registration updated successfully';
            } else {
              
                $validatedData['user_id'] = $request->user()->id;
                PreRegistration::create($validatedData);
                $message = 'Pre-registration created successfully';
            }
           
            DB::commit();
            
            return ApiResponse::success([], $message);

        } catch (\Exception $e) {
        
            DB::rollBack();

       
            return ApiResponse::error('An error occurred while processing your pre-registration', 500);
        }
    }
}
