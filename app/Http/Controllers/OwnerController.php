<?php

namespace App\Http\Controllers;

use App\Enums\PaymentTypes;
use App\Enums\UserTypes;
use App\Models\Payment;
use App\Models\Property;

class OwnerController extends Controller
{
    public function getProperties()
    {
        if (auth()->user('api')->user_type !== UserTypes::OWNER) {
            return response()->json(['message' => 'Ha ocurrido un error, contacte al administrador.'], 403);
        }

        return Property::with('tenant', 'owner', 'broker')->whereHas('owner', function ($q) {
            $q->where('owner_id', auth()->user('api')->owner->id);
        })->orderBy('id', 'desc')->paginate(15);
    }

    public function getPropertiesWithoutPag()
    {
        if (auth()->user('api')->user_type !== UserTypes::OWNER) {
            return response()->json(['message' => 'Ha ocurrido un error, contacte al administrador.'], 403);
        }

        return Property::with('tenant', 'owner', 'broker')->whereHas('owner', function ($q) {
            $q->where('owner_id', auth()->user('api')->owner->id);
        })->orderBy('id', 'desc')->get();
    }

    public function showProperty($id)
    {
        $property = Property::with('tenant', 'owner', 'claims', 'payments', 'broker')->find($id);

        if (! auth()->user('api')->owner) {
            return response()->json(['message' => 'Ha ocurrido un error, contacte al administrador.'], 403);
        }

        if (auth()->user('api')->owner->id !== $property->owner_id) {
            return response()->json(['message' => 'No tienes los permisos para acceder a este recurso.'], 403);
        }

        return $property;
    }

    public function getMyPayments()
    {
        return Payment::where('owner_id', auth()->user('api')->owner->id)
            ->where('payment_type', PaymentTypes::OWNER_PAYMENT)
            ->paginate(15);
    }
}
