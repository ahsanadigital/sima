<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdatePassword extends Controller
{
  /**
   * The Main Edit User Password
   *
   * @package collage-life
   * @since 1.0.0
   */
  public function index()
  {
    $data['title'] = 'Change Password';
    return view('password', $data);
  }

  /**
   * The Updater Edit User Password
   *
   * @package collage-life
   * @since 1.0.0
   */
  public function update(Request $request, User $user, Admin $admin)
  {
    $cUser      = auth()->guard('user')->user();
    $cAdmin     = auth()->guard('admin')->user();
    $validation = Validator::make($request->all(), [
      'password'         => 'required|min:8',
      'password_confirm' => 'required|same:password',
    ]);
    
    if($validation->fails()) {
      return response()->json([
        'message' => 'You must re-check again the requirement.',
        'error'   => false,
        'code'    => 403,
        'debug'   => $validation->errors()->all()
      ], 403);
    } else {
      $data['password'] = Hash::make($request->password);

      if($cUser) {
        $user = $user->find($cUser->id)->update($data);
        
        return response()->json([
          'message' => 'Successfuly edit your profile data!',
          'error'   => false,
          'code'    => 200,
          'data'    => $data,
        ], 200);
      } elseif($cAdmin) {
        $user = $admin->find($cAdmin->id)->update($data);
        
        return response()->json([
          'message' => 'Successfuly edit your profile data!',
          'error'   => false,
          'code'    => 200,
          'data'    => $data,
        ], 200);
      } else {
        return response()->json([
          'message' => 'User was not found. Update data aborted!',
          'error'   => false,
          'code'    => 401,
        ], 401);
      }
    }
  }
}
