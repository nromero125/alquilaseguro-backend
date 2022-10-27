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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenant $tenant)
    {
        //
    }

    public function getMyPayments()
    {
        return Payment::where('tenant_id', auth()->user('api')->tenant->id)->orderBy('id', 'desc')->paginate(15);
    }

    public function createPayment(PaymentValidation $request)
    {
        if (! auth()->user('api')->tenant) {
            return response()->json(['message' => 'Ha ocurrido un error, contacte al administrador.'], 403);
        }
        $data = $request->all();
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
