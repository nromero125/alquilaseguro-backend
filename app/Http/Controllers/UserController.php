<?php

namespace App\Http\Controllers;

use App\Enums\UserTypes;
use App\Http\Requests\BrokerUpdateValidation;
use App\Http\Requests\StoreBrokerValidation;
use App\Http\Requests\StoreInsurerValidation;
use App\Models\Broker;
use App\Models\Insurer;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function createBroker(StoreBrokerValidation $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => $request->firstname,
            'user_type' => UserTypes::BROKER,
        ]);

        Broker::create([
            'real_estate_id' => auth()->user('api')->broker->real_estate_id,
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'identification' => $request->identification,
            'address' => $request->address,
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
        ]);

        return response(['message' => 'Usuario creado exitosamente', 'success' => true]);
    }

    public function createInsurer(StoreInsurerValidation $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => $request->firstname,
            'user_type' => UserTypes::INSURER,
        ]);

        Insurer::create([
            'insurance_id' => auth()->user('api')->insurer->insurance_id,
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'identification' => $request->identification,
            'address' => $request->address,
        ]);

        return response(['message' => 'Usuario creado exitosamente', 'success' => true]);
    }

    public function updateBrokerUser(BrokerUpdateValidation $request, Broker $broker)
    {
        $broker->update($request->except(['email', 'password']));
        if ($request->has('password')) {
            User::where('id', $broker->user_id)->update(['password' => bcrypt($request->password)]);
        }

        return response(['message' => 'Usuario actualizado exitosamente', 'success' => true, 'broker' => $broker->load('user')]);
    }

    public function updateInsurerUser(Request $request, Insurer $insurer)
    {
        $insurer->update($request->except(['email', 'password']));
        if ($request->has('password')) {
            User::where('id', $insurer->user_id)->update(['password' => bcrypt($request->password)]);
        }

        return response(['message' => 'Usuario actualizado exitosamente', 'success' => true, $insurer->load('user')]);
    }

    public function getUsers()
    {
        if (auth()->user('api')->user_type == UserTypes::INSURER_ADMIN) {
            return Insurer::with('user')->where('insurance_id', auth()->user('api')->insurer->insurance_id)->paginate(15);
        }

        if (auth()->user('api')->user_type == UserTypes::BROKER_ADMIN) {
            return Broker::with('user')->where('real_estate_id', auth()->user('api')->broker->real_estate_id)->paginate(15);
        }

        return response()->json(['message' => 'No tienes permisos.', 'success' => false], 403);
    }
}
