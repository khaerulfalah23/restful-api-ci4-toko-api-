<?php

namespace App\Controllers;

use App\Models\MLogin;
use App\Models\MMember;

class LoginController extends RestfulController
{

  public function login()
  {
    $email = $this->request->getVar('email');
    $password = $this->request->getVar('password');

    $model = new MMember();
    $member = $model->where(['email' => $email])->first();
    if (!$member) {
      return $this->responseHasil(400, false, "Email tidak ditemukan");
    }
    if (!password_verify($password, $member['password'])) {
      return $this->responseHasil(400, false, "Password tidak valid");
    }

    $login = new MLogin();
    $auth_key = $this->RandomString();
    $login->save([
      'member_id' => $member['id'],
      'auth_key' => $auth_key
    ]);
    $data = [
      'token' => $auth_key,
      'user' => [
        'id' => $member['id'],
        'email' => $member['email'],
      ]
    ];
    return $this->responseHasil(200, true, $data);
  }

  private function RandomString($length = 100)
  {
    $karakkter = '012345678dssd9abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $panjang_karakter = strlen($karakkter);
    $str = '';
    for ($i = 0; $i < $length; $i++) {
      $str .= $karakkter[rand(0, $panjang_karakter - 1)];
    }
    return $str;
  }
}
