<?php

namespace App\Http\Controllers;

use App\Enums\PaymentTypes;
use App\Http\Requests\PaymentValidation;
use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(): void
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create(): void
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return void
     */
    public function store(Request $request): void
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  Tenant  $tenant
     * @return void
     */
    public function show(Tenant $tenant)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tenant  $tenant
     * @return void
     */
    public function edit(Tenant $tenant)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Tenant  $tenant
     * @return void
     */
    public function update(Request $request, Tenant $tenant)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tenant  $tenant
     * @return void
     */
    public function destroy(Tenant $tenant)
    {
    }

    public function getMyPayments()
    {
        return Payment::with('paidProperty', 'tenant')
            ->where('tenant_id', auth()->user('api')->tenant->id)
            ->orderBy('id', 'desc')
            ->paginate(15);
    }

    public function createPayment(PaymentValidation $request)
    {
        if (! auth()->user('api')->tenant) {
            return response()->json(['message' => 'Ha ocurrido un error, contacte al administrador.'], 403);
        }

        $data = $request->validated();
        $data['payment_type'] = PaymentTypes::PROPERTY_PAYMENT;
        $data['tenant_id'] = auth()->user('api')->tenant->id;
        $payment = Payment::create($data);

        if ($request->hasFile('voucher') && $request->file('voucher')->isValid()) {
            $filename = md5($request->file('voucher')->getClientOriginalName()).'.'.$request->file('voucher')->getClientOriginalExtension();
            $payment->addMediaFromRequest('voucher')->usingFileName($filename)->toMediaCollection('voucher', 's3');
        }

        return response()->json(['success' => true, 'payment' => $payment]);
    }
}
