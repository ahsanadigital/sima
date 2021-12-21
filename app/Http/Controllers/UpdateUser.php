<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateUser extends Controller
{
  /**
   * The Main Edit Data User
   *
   * @package collage-life
   * @since 1.0.0
   */
  public function index()
  {
    $data['title'] = 'Edit My Profile';
    return view('profile', $data);
  }

  /**
   * The Updater Edit Data User
   *
   * @package collage-life
   * @since 1.0.0
   */
  public function update(Request $request, User $user, Admin $admin)
  {
    $validation = Validator::make($request->all(), [
      'pp'            => 'file|max:2048|mimes:jpg,jpeg,png',
      'fullname'      => 'required',
      'email'         => 'required|email',
      'study'         => '',
      'university'    => '',
      'date_birth'    => auth()->guard('user')->user() ? 'required' : '',
      'phone_number'  => '',
    ]);

    if($validation->fails()) {
      return response()->json([
        'message' => 'You must re-check again the requirement.',
        'error'   => false,
        'code'    => 401,
        'debug'   => $validation->errors()->all()
      ], 401);
    } else {
      $data   = $request->except(['_token', 'pp']);
      $cUser  = auth()->guard('user')->user();
      $cAdmin = auth()->guard('admin')->user();

      if($request->pp) {
        $upload = $request->pp;
        $name   = uniqid('upload-') . '_' . md5(now()) . '.' . $upload->getClientOriginalExtension();
        $path   = 'storage/images';
        $uPath  = public_path($path);

        $upload->move($uPath, $name);

        $data['pp'] = "{$path}/{$name}";
      }

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
