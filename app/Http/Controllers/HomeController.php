<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
  /**
   * Homepage for login
   *
   * @package collage-life
   * @since 1.0.0
   * @author Unknown
   */
  public function main()
  {
    $data['title'] = 'Masuk Dahulu';
    return view('main', $data);
  }

  /**
   * Processing Data
   *
   * @package collage-life
   * @since 1.0.0
   * @author Unknown
   */
  public function process(Request $request, Admin $admin, User $user)
  {
    # Initialize request catcher
    $username = htmlspecialchars(strip_tags((string) $request->username));
    $password = htmlspecialchars(strip_tags((string) $request->password));
    $remember = htmlspecialchars(strip_tags((bool) $request->remember));

    # Checking user if is user or admin?
    $checkUser  = $user->where('username', $username);
    $checkAdmin = $admin->where('username', $username);

    # If is user
    if($checkUser->count() > 0) {
      $data        = $checkUser->first();
      $getPassword = $data['password'];
      $checkPass   = Hash::check($password, $getPassword);

      # Check Password
      if($checkPass == true)
      {
        Auth::guard('user')->login($data, $remember);

        return response()->json([
          'error'     => false,
          'code'      => 200,
          'redirect'  => route('panel.home'),
          'message'   => 'Anda telah berhasil masuk, sistem akan mengarahkan ke halaman panel dengan otomatis dalam 5 detik kedepan.',
        ], 200);
      } else {
        return response()->json([
          'error'     => true,
          'code'      => 401,
          'message'   => 'Maaf, kata sandi yang anda masukkan tidak cocok. Silahkan pastikan anda tidak menuliskan kata sandi terhindar dari salah ketik.',
        ], 401);
      }

    # Check if is admin
    } elseif($checkAdmin->count() > 0) {
      $data        = $checkAdmin->first();
      $getPassword = $data['password'];
      $checkPass   = Hash::check($password, $getPassword);

      # Check Password
      if($checkPass == true)
      {
        Auth::guard('admin')->login($data, $remember);

        return response()->json([
          'error'   => false,
          'code'    => 200,
          'redirect'  => route('panel.home'),
          'message' => 'Anda telah berhasil masuk, sistem akan mengarahkan ke halaman panel dengan otomatis dalam 5 detik kedepan.',
        ], 200);
      } else {
        return response()->json([
          'error'   => true,
          'code'    => 401,
          'message' => 'Maaf, kata sandi yang anda masukkan tidak cocok. Silahkan pastikan anda tidak menuliskan kata sandi terhindar dari salah ketik.',
        ], 401);
      }

    # If neither both, return false
    } else {
      return response()->json([
        'error'     => true,
        'code'      => 401,
        'message'   => 'Maaf, akun anda tidak dapat ditemukan. Silahkan cek lagi detail akun anda.',
      ], 401);
    }
  }
}
