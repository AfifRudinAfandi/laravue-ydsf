<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Repositories\Repository;
use App\Repositories\RewardRepository;
use Illuminate\Http\Request;

class RewardController extends Controller
{
  protected $model;
  protected $rewardRepo;
  public function __construct(Reward $reward, RewardRepository $rewardRepo)
  {
    $this->model = new Repository($reward);
    $this->rewardRepo = $rewardRepo;
  }

  /**
   * Get all donation
   * 
   * @return json
   */
  public function getAll()
  {
    return $this->model->getAll();
  }


  /**
   * Create donation
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return json
   */
  public function create(Request $request)
  {
    $data = $this->rewardRepo->storeRequest($request);
    return $this->model->create($data);
  }

  /**
   * Update campaign message
   * 
   * @param Illuminate\Http\Request $request
   * @param int $id
   * 
   * @return json
   */
  public function update(Request $request, $id)
  {
    $data = $this->rewardRepo->storeRequest($request);
    return $this->model->updateById($id, $data);
  }

  /**
   * Delete specific donations by ID
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
   * Bulk delete by IDs
   * 
   * @param int $id
   * 
   * @return json
   */
  public function bulkDelete(Request $request)
  {
    return $this->model->bulkDelete($request->ids);
  }
}
