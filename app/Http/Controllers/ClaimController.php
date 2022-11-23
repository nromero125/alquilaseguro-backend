<?php

namespace App\Http\Controllers;

use App\Enums\ClaimStatus;
use App\Enums\UserTypes;
use App\Http\Requests\ClaimUpdateValidation;
use App\Http\Requests\ClaimValidation;
use App\Models\Claim;
use App\Models\Property;

class ClaimController extends Controller
{
    public function getMyClaims()
    {
        return Claim::with('user.tenant', 'user.owner', 'property')->where('user_id', auth()->user('api')->id)->orderBy('id', 'desc')->get();
    }

    public function brokerGetClaims()
    {
        return Claim::with('user.tenant', 'user.owner', 'property')->whereIn('property_id', auth()->user('api')->broker->properties->pluck('id'))->orderBy('id', 'desc')->get();
    }

    public function store(ClaimValidation $request)
    {
        $data = $request->all();
        $property = Property::find($request->property_id);
        $data['property_id'] = $property->id;
        $data['status'] = ClaimStatus::In_progress;
        $data['user_id'] = auth()->user('api')->id;
        $data['insurance_id'] = $property->policy->insurance_id;
        if (auth()->user('api')->user_type == UserTypes::TENANT) {
            $data['property_id'] = auth()->user('api')->tenant->property->id;
        }

        $claim = Claim::create($data);
        if ($request->hasFile('evidence') && $request->file('evidence')[0]->isValid()) {
            $claim->addMultipleMediaFromRequest(['evidence'])->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('evidence', 's3');
            });
        }

        return response()->json(['success' => true, 'claim' => $claim]);
    }

    public function show(Claim $claim)
    {
        return $claim->load('user', 'property');
    }

    public function index()
    {
        return Claim::with('user.tenant', 'user.owner', 'property')->where('insurance_id', auth()->user('api')->insurer->insurance_id)->get();
    }

    public function updateClaim(ClaimUpdateValidation $request, Claim $claim)
    {
        $claim->update($request->all());

        return $claim;
    }
}
