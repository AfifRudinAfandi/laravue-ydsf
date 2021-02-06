<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
  protected $model;
  protected $relationCol;

  public function __construct(Admin $admin)
  {
    $this->model = new Repository($admin);
    $this->relationCol = ['regional:id,name'];
  }

  /**
   * Get All Users
   * 
   * @return json
   */
  public function getAll()
  {
    return $this->model->getAll($this->relationCol);
  }

  /**
   * Get specific admin by ID
   * 
   * @param int   $id
   * 
   * @return json
   */
  public function getById($id)
  {
    return $this->model->getById($id, $this->relationCol);
  }

  /**
   * Add Admin
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return json
   */
  public function create(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'regional_id' => 'required',
        'name' => 'required',
        'email' => 'required|email|unique:admins',
        'password' => 'required',
      ],
      [
        'required' => ':attribute harus diisi',
        'email' => 'Format email salah',
        'unique' => 'Email sudah terdaftar'
      ],
      [
        'regional_id' => 'Cabang',
        'name' => 'Nama',
        'email' => 'Email',
        'password' => 'Kata Sandi'
      ]
    );

    if ($validator->fails())
      throw new \Exception($validator->errors(), 400);

    try {
      $data = [
        'regional_id' => $request->regional_id,
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
      ];

      return $this->model->create($data);
    } catch (\Exception $err) {
      throw $err;
    }
  }

  /**
   * Update Admin Data
   * 
   * @param Illuminate\Http\Request $request
   * @param int $id
   * 
   * @return json
   */
  public function update(Request $request, $id)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'regional_id' => 'required',
        'name' => 'required',
        'email' => 'required|email',
      ],
      [
        'required' => ':attribute harus diisi',
        'email' => 'Format email salah',
      ],
      [
        'regional_id' => 'Cabang',
        'name' => 'Nama',
        'email' => 'Email',
      ]
    );

    if ($validator->fails())
      throw new \Exception($validator->errors(), 400);

    try {
      $data = [
        'name' => $request->name,
        'email' => $request->email,
        'regional_id' => $request->regional_id,
      ];

      if (isset($request->password) && !empty($request->password))
        $data = array_merge(['password' => Hash::make($request->password)], $data);

      return $this->model->updateById($id, $data);
    } catch (\Exception $err) {
      throw $err;
    }
  }

  /**
   * Delete specific admin by ID
   * 
   * @param int $id
   * 
   * @return json
   */
  public function delete($id)
  {
    return $this->model->deleteById($id);
  }
}
