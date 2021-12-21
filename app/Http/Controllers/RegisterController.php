<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
  function main()
  {
    return view('register-index');
  }

  function process(Request $request)
  {
    $this->validate($request, [
      'fullname'      => 'required',
      'email'         => 'required|email',
      'study'         => 'required',
      'university'    => 'required',
      'date_birth'    => 'required',
      'phone_number'  => 'required',
    ]);

    $data = $request->except(['_token']);
    $user = User::create($data);

    Auth::guard('user')->login($user);

    return redirect()->route('panel.home');
  }
}
