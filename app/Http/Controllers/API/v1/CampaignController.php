<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignCategory;
use App\Models\CampaignProgress;
use App\Repositories\CampaignRepository;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
  protected $campaign;
  protected $progress;
  protected $category;
  protected $campaignRepo;

  protected $relationCol;
  protected $selectCol;

  public function __construct(
    Campaign $campaign,
    CampaignProgress $progress,
    CampaignCategory $category,
    CampaignRepository $campaignRepo
  ) {
    $this->campaign = new Repository($campaign);
    $this->progress = new Repository($progress);
    $this->category = new Repository($category);
    $this->campaignRepo = $campaignRepo;

    $this->relationCol = ['admin:id,name', 'regional:id,name', 'category:id,category,icon', 'donations:id,nominal,is_verified,user_id,campaign_id'];
    $this->selectCol = [
      'id', 'admin_id', 'cover_image_url', 'created_at', 'max_time', 'max_nominal', 'slug', 'title', 'video_url', 'campaign_category_id', 'location', 'is_complete'
    ];
  }

  /**
   * Get all campaign
   * 
   * @return json
   */
  public function getAllCampaign()
  {
    return $this->campaign->getByColumns([
      ['is_published', 1],
    ], $this->relationCol, 'created_at', 'DESC', 0, $this->selectCol);
  }


  /** Get all campaign location
   * 
   * @return json
   */
  public function getCampaignLocation()
  {
    return Campaign::select('location')->groupBy('location')->pluck('location');
  }


  /**
   * Get campaign for home feed, limit by 4
   * 
   * @return json
   */
  public function getHomeCampaign()
  {
    try {
      $open = Campaign::where([['is_published', 1], ['max_time', '>=', Carbon::now()]])->orWhere([['is_published', 1], ['max_time', '=', NULL]])->with($this->relationCol)->orderBy('created_at', 'ASC')->select($this->selectCol)->get();

      return response()->json($open);
    } catch (\Exception $err) {
      return response()->json([
        'status' => $err->getCode(),
        'message' => 'Terjadi kesalahan dalam mengambil data',
        'trace' => $err->getMessage()
      ], 500);
    }
  }

  /**
   * Get campaign for home feed, limit by 4
   * 
   * @return json
   */
  public function getRecentCampaign()
  {
    try {
      $open = Campaign::where([['is_published', 1], ['max_time', '>=', Carbon::now()]])->with($this->relationCol)->orderBy('created_at', 'DESC')->select($this->selectCol)->get();

      return response()->json($open);
    } catch (\Exception $err) {
      return response()->json([
        'status' => $err->getCode(),
        'message' => 'Terjadi kesalahan dalam mengambil data',
        'trace' => $err->getMessage()
      ], 500);
    }
  }

  /**
   * Get specific campaign by Slug
   * 
   * @param int $id
   * 
   * @return json
   */
  public function getCampaignBySlug($slug)
  {
    return $this->campaign->getByColumns([
      ['slug', $slug],
      ['is_published', 1]
    ], $this->relationCol);
  }

  /**
   * Get specific campaign by Id
   * 
   * @param int $id
   * 
   * @return json
   */
  public function getCampaignById($id)
  {
    return $this->campaign->getByColumns([['id', $id], ['is_published', 1]], $this->relationCol);
  }

  /**
   * Get specific campaign by Regional Id
   * 
   * @param int $id
   * 
   * @return json
   */
  public function getCampaignByRegionalId($regionalId)
  {
    return $this->campaign->getByColumns([
      ['regional_id', $regionalId],
      ['is_published', 1]
    ], $this->relationCol, 'created_at', 'DESC', 0, $this->selectCol);
  }

  /**
   * Get specific name by campaign Id
   * 
   * @param int $id
   * 
   * @return json
   */
  public function getCampaignTitle($id)
  {
    return $this->campaign->getById($id, [], 'created_at', 'DESC', 1, ['title']);
  }

  /**
   * Get all campaign progress by campaign's ID
   * 
   * @return json
   */
  public function getProgressByCampaignId($campaign_id)
  {
    return $this->progress->getByColumns(['campaign_id' => $campaign_id], ['author:id,name'], 'created_at', 'DESC', 5);
  }

  /**
   * Get sepecific progress by ID
   * 
   * @return json
   */
  public function getProgressById($id)
  {
    return $this->progress->getById($id);
  }

  /**
   * Get sepecific category by ID
   * 
   * @return json
   */
  public function getCategoryById($id)
  {
    return $this->category->getById($id);
  }

  /**
   * Get all campaign categories
   * 
   * @return json
   */
  public function getAllCategories()
  {
    return $this->category->getAll();
  }

  /**
   * Create campaign
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return json
   */
  public function createCampaign(Request $request)
  {
    $data = $this->campaignRepo->storeCampaign($request);
    return $this->campaign->create($data);
  }

  /**
   * Create campaign
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return json
   */
  public function createProgress(Request $request)
  {
    $data = $this->campaignRepo->storeProgress($request);
    return $this->progress->create($data);
  }

  /**
   * Create campaign
   * 
   * @param Illuminate\Http\Request $request
   * 
   * @return json
   */
  public function createCategory(Request $request)
  {
    return $this->category->create([
      'category' => $request->category,
      'icon' => $request->icon
    ]);
  }

  /**
   * Update campaign
   * 
   * @param Illuminate\Http\Request $request
   * @param int $id
   * 
   * @return json
   */
  public function updateCampaign(Request $request, $id)
  {
    $data = $this->campaignRepo->storeCampaign($request);
    return $this->campaign->updateById($id, $data);
  }

  /**
   * Update campaign progress
   * 
   * @param Illuminate\Http\Request $request
   * @param int $id
   * 
   * @return json
   */
  public function updateProgress(Request $request, $id)
  {
    $data = $this->campaignRepo->storeProgress($request);
    return $this->progress->updateById($id, $data);
  }

  /**
   * Update campaign category
   * 
   * @param Illuminate\Http\Request $request
   * @param int $id
   * 
   * @return json
   */
  public function updateCategory(Request $request, $id)
  {
    return $this->category->updateById($id, [
      'category' => $request->category,
      'icon' => $request->icon
    ]);
  }

  /**
   * Delete specific campaign by ID
   * 
   * @param int $id
   * 
   * @return json
   */
  public function deleteCampaign($id)
  {
    $this->progress->deleteByColumns(['campaign_id' => $id]);
    return $this->campaign->deleteById($id);
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
    return $this->campaign->bulkDelete($request->ids);
  }

  /**
   * Delete specific campaign progress by ID
   * 
   * @param int $id
   * 
   * @return json
   */
  public function deleteProgress($id)
  {
    return $this->progress->deleteById($id);
  }

  /**
   * Delete specific campaign category by ID
   * 
   * @param int $id
   * 
   * @return json
   */
  public function deleteCategory($id)
  {
    return $this->category->deleteById($id);
  }
}
