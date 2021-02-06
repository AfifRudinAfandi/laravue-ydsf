<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\Reward;
use App\Models\User;
use App\Repositories\Repository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
  protected $model;
  protected $userRepo;
  public function __construct(User $user, UserRepository $userRepo)
  {
    $this->model = new Repository($user);
    $this->userRepo = $userRepo;
  }

  /**
   * Get All Users
   * 
   * @return json
   */
  public function getAll()
  {
    return $this->model->getAll();
  }

  /**
   * Get specific user
   * 
   * @param int $id
   * 
   * @return json
   */
  public function getById($id)
  {
    return $this->model->getById($id);
  }

  /**
   * Create user
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return json
   */
  public function create(Request $request)
  {
    $data = $this->userRepo->storeRequest($request);
    return $this->model->create($data);
  }

  /**
   * Complete/Update user data
   * 
   * @param Illuminate\Http\Request $request
   * @param int $id
   * 
   * @return json
   */
  public function update(Request $request, $id)
  {
    $this->validate(
      $request,
      [
        'name' => 'required',
        'phone' => 'nullable|unique:users,phone,' . $id,
        'email' => 'nullable|email|unique:users,email,' . $id,
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

    return $this->model->updateById($id, [
      'username' => $request->username,
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'address' => $request->address,
      'city' => $request->city,
    ]);
  }


  /**
   * Update password
   * 
   * @param Illuminate\Http\Request $request
   * @param int $id
   * 
   * @return json
   */
  public function updatePassword(Request $request, $id)
  {
    $this->validate(
      $request,
      [
        'password' => 'nullable|min:6',
        'new_password' => 'required|confirmed|min:6',
      ],
      [
        'required' => ':attribute harus diisi',
        'min' => ':attribute minimal :min karakter',
        'confirmed' => ':attribute tidak cocok'
      ],
      [
        'password' => 'Password saat ini',
        'new_password' => 'Password baru'
      ]
    );

    $user = User::where('id', $id)->firstOrFail();
    if ($user->password != "") {
      if (Hash::check($request->password, $user->password))
        return $this->model->updateById($id, ['password' => Hash::make($request->new_password)]);

      return response()->json([
        'status' => 200,
        'message' => 'Password saat ini tidak cocok',
      ], 500);
    } else {
      return $this->model->updateById($id, ['password' => Hash::make($request->new_password)]);
    }
  }

  /**
   * Update avatar image
   * 
   * @param Illuminate\Http\Request $request
   * @param int $id
   * 
   * @return json
   */
  public function updateAvatar(Request $request, $id)
  {

    $this->validate($request, ['avatar' => 'required']);
    $file = $request->file('avatar');
    $originalFileName = time() . '_uploaded_' . $file->getClientOriginalName();

    $filename = storage_path('app/public/' . $originalFileName);
    $img = Image::make($request->avatar)->resizeCanvas(400, 400)->save($filename);

    if ($img)
      return $this->model->updateById($id, ['avatar' => $originalFileName]);

    return response()->json([
      'status' => 500,
      'message' => 'Terjadi kesalahan saat menyimpan gambar',
    ], 500);
  }

  /**
   * Update is_donate Status
   * 
   * @param int $id
   * 
   * @return json
   */
  public function updateStatus($id)
  {
    return $this->model->updateById($id, ['is_donate' => 1]);
  }

  /**
   * Update is_donate Status
   * 
   * @param int $id
   * @param int $show
   * 
   * @return json
   */
  public function updateDisplayName($id, $show)
  {
    return $this->model->updateById($id, ['is_display_name' => $show]);
  }

  /**
   * Delete specific user by ID
   * 
   * @param int $id
   * 
   * @return json
   */
  public function delete($id)
  {
    return $this->model->deleteById($id);
  }

  /**
   * Get notification by user ID
   */
  public function getNotifByID($user_id)
  {
    Notification::where('user_id', $user_id)->update(['is_read' => 1]);

    return Notification::where('user_id', $user_id)->orderBy('created_at', 'DESC')->limit(5)->get();
  }

  /**
   * Get Total of unread notification
   */
  public function getNotifCount($userId)
  {
    return Notification::where([
      ['user_id', $userId],
      ['is_read', 0],
    ])->select('id')->count();
  }

  /**
   * Get reward data
   */
  public function getReward($userId)
  {
    $getDonation = Donation::where([
      ['user_id', $userId],
      ['is_verified', '>', 0]
    ])->select('id')->first();

    if ($getDonation) {
      return Reward::where('is_published', '>', 0)->get();
    }

    return [];
  }
}
