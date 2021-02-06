<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserRepository
{

  /**
   * Validate data from request
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return void
   */
  public function validateRequest(Request $request, $id)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'name' => 'required',
        'phone' => 'required|unique:users,phone,' . $id,
        'email' => 'required|email|unique:users,email,' . $id,
      ],
      [
        'required' => ':attribute harus diisi',
        'email' => 'format email salah',
        'unique' => ':attribute sudah digunakan'
      ],
      [
        'name' => 'Nama',
        'phone' => 'Nomor telepon',
        'email' => 'Email'
      ]
    );

    return $validator;
  }

  /**
   * Change request to store donation data
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return array
   */
  public function storeRequest(Request $request, $id = null)
  {
    $this->validateRequest($request, $id);
    return [
      'username' => $request->username,
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'address' => $this->nullable($request->address),
    ];
  }

  /**
   * Set null for data if empty
   * 
   * @param mixed $data
   * 
   * @return mixed
   */
  public function nullable($data)
  {
    if (empty($data))
      return null;

    return $data;
  }
}
