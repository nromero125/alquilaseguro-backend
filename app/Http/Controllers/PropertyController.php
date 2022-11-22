<?php

namespace App\Http\Controllers;

use App\Enums\UserTypes;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user('api')->user_type == UserTypes::OWNER) {
            return Property::where('owner_id', auth()->user('api')->owner->id)->orderBy('id', 'desc')->get();
        }

        if (auth()->user('api')->user_type == UserTypes::TENANT) {
            return Property::where('tenant_id', auth()->user('api')->tenant->id)->orderBy('id', 'desc')->get();
        }

        if (auth()->user('api')->user_type == UserTypes::BROKER) {
            return Property::where('broker_id', auth()->user('api')->broker->id)->orderBy('id', 'desc')->get();
        }

        if (auth()->user('api')->user_type == UserTypes::BROKER_ADMIN) {
            return Property::where('real_estate_id', auth()->user('api')->broker->real_estate_id)->orderBy('id', 'desc')->get();
        }

        if (auth()->user('api')->user_type == UserTypes::INSURER || auth()->user('api')->user_type == UserTypes::INSURER_ADMIN) {
            $insuranceId = auth()->user('api')->insurer->insurance_id;
            return Property::whereHas('policy', function ($q) use ($insuranceId) {
                $q->where('insurance_id', $insuranceId);
            })->with('policy')->orderBy('id', 'desc')->get();
        }

        return response()->json(['message' => 'are you lost?']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return $property->load('claims', 'broker', 'owner', 'tenant', 'payments');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }
}
