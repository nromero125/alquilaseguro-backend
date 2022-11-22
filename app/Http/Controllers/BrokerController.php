<?php

namespace App\Http\Controllers;

use App\Enums\PaymentTypes;
use App\Models\Payment;
use App\Models\Property;

class BrokerController extends Controller
{
    public function getProperties()
    {
        if (! auth()->user('api')->broker) {
            return response()->json(['message' => 'Ha ocurrido un error, contacte al administrador.'], 403);
        }

        return Property::with('tenant', 'owner')->whereHas('broker', function ($q) {
            $q->where('broker_id', auth()->user('api')->broker->id);
        })->orderBy('id', 'desc')->get();
    }

    public function showProperty($id)
    {
        $property = Property::with('tenant', 'owner', 'claims', 'payments')->find($id);

        if (! auth()->user('api')->broker) {
            return response()->json(['message' => 'Ha ocurrido un error, contacte al administrador.'], 403);
        }

        if (auth()->user('api')->broker->id !== $property->broker_id) {
            return response()->json(['message' => 'No tienes los permisos para acceder a este recurso.'], 403);
        }

        return $property;
    }

    public function getMyPayments()
    {
        return Payment::where('broker_id', auth()->user('api')->broker->id)
        ->where('payment_type', PaymentTypes::BROKER_PAYMENT)
        ->get();
    }
}
