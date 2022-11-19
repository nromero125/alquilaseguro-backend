<?php

namespace App\Http\Controllers;

use App\Enums\ClaimStatus;
use App\Enums\UserTypes;
use App\Models\Broker;
use App\Models\Claim;
use App\Models\Payment;
use App\Models\Property;

class HomeController extends Controller
{
    public function home()
    {
        //Tenant
        if (auth()->user('api')->user_type == UserTypes::TENANT) {
            $late = Payment::where('tenant_id', auth()->user('api')->tenant)->where('is_late', true)->count();

            return response()->json([
                'count_payments' => auth()->user('api')->tenant->payments->count(),
                'count_late_payments' => $late,
                'count_claims' => auth()->user('api')->claims->count(),
            ]);
        }

        if (auth()->user('api')->user_type == UserTypes::BROKER) {
            return response()->json([
                'count_received_payments' => auth()->user('api')->broker->payments->count(),
                'count_properties' => auth()->user('api')->broker->properties->count(),
            ]);
        }

        if (auth()->user('api')->user_type == UserTypes::BROKER_ADMIN) {
            return response()->json([
                'count_received_payments' => auth()->user('api')->broker->payments->count(),
                'count_properties' => Property::where('real_estate_id', auth()->user('api')->broker->real_estate_id)->count(),
                'broker_count' => Broker::where('real_estate_id', auth()->user('api')->broker->real_estate_id)->count(),
            ]);
        }

        if (auth()->user('api')->user_type == UserTypes::INSURER || auth()->user('api')->user_type == UserTypes::INSURANCE_ADMIN) {
            $insurance_id = auth()->user('api')->insurer->insurance_id;

            return response()->json([
                'count_claims' => Claim::whereHas('property.policy', function ($q) use ($insurance_id) {
                    $q->where('insurance_id', $insurance_id);
                })->count(),
                'count_in_progress_claims' => Claim::whereHas('property.policy', function ($q) use ($insurance_id) {
                    $q->where('insurance_id', $insurance_id)->where('status', ClaimStatus::In_progress);
                })->count(),
                'count_completed_claims' => Claim::whereHas('property.policy', function ($q) use ($insurance_id) {
                    $q->where('insurance_id', $insurance_id)->where('status', ClaimStatus::Completed);
                })->count(),

            ]);
        }
    }
}
