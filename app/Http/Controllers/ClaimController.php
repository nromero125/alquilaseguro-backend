<?php

namespace App\Http\Controllers;

use App\Enums\ClaimStatus;
use App\Http\Requests\ClaimValidation;
use App\Models\Claim;

class ClaimController extends Controller
{
    public function getMyClaims()
    {
        return Claim::with('user', 'property')->where('user_id', auth()->user('api')->id)->orderBy('id', 'desc')->paginate(15);
    }

    public function brokerGetClaims()
    {
        return Claim::with('user', 'property')->whereIn('property_id', auth()->user('api')->broker->properties->pluck('id'))->orderBy('id', 'desc')->paginate(15);
    }

    public function store(ClaimValidation $request)
    {
        $data = $request->all();
        $data['status'] = ClaimStatus::IN_PROGRESS;
        $data['user_id'] = auth()->user('api')->id;
        $claim = Claim::create($data);
        if ($request->hasFile('evidence') && $request->file('evidence')[0]->isValid()) {
            $claim->addMultipleMediaFromRequest(['evidence'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('evidence', 's3');
            });
        }

        return response()->json(['success' => true, 'claim' => $claim]);
    }
}
