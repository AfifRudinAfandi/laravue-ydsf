<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Regional;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class RegionalController extends Controller
{
  protected $model;
  public function __construct(Regional $regional)
  {
    $this->model = new Repository($regional);
  }

  /**
   * Get all data
   * 
   * @return json
   */
  public function getAll()
  {
    return Regional::withCount([
      'campaigns as hasDonation' => function ($q) {
        $q->whereHas('donations', function ($r) {
          $r->where('is_verified', '>=', 1);
        });
      },
      'campaigns as hasntDonation' => function ($q) {
        $q->whereHas('donations', function ($r) {
          $r->where('is_verified', '<=', 0);
        });
      }
    ])->get();
  }

  /**
   * Get specific data by ID
   * 
   * @param int $id
   * 
   * @return json
   */
  public function getById($id)
  {
    return Regional::where('id', $id)->withCount([
      'campaigns as hasDonation' => function ($q) {
        $q->whereHas('donations', function ($r) {
          $r->where('is_verified', '>=', 1);
        });
      },
      'campaigns as hasntDonation' => function ($q) {
        $q->whereHas('donations', function ($r) {
          $r->where('is_verified', '<=', 0);
        });
      }
    ])->get();
  }

  /**
   * Add data
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return json
   */
  public function create(Request $request)
  {
    $request->validate([
      'name' => 'required|string',
      'address' => 'required',
    ]);

    return $this->model->create([
      'name' => $request->name,
      'address' => $request->address,
      'image' => $request->image ?? null
    ]);
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
    $this->checkRequestName($request->name);
    return $this->model->updateById($id, [
      'name' => $request->name
    ]);
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
