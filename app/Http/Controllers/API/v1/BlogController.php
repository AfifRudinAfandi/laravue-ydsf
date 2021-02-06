<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class BlogController extends Controller
{
  protected $model;
  protected $blogRepo;
  protected $relationCol;

  public function __construct(Blog $blog, BlogRepository $repo)
  {
    $this->model = new Repository($blog);
    $this->blogRepo = $repo;
    $this->relationCol = ['author:id,name'];
  }

  /**
   * Get all donation
   * 
   * @return json
   */
  public function getAll()
  {
    return $this->model->getByColumns(['is_published' => 1], $this->relationCol);
  }

  /**
   * Get specific blog by ID
   * 
   * @param int $id
   * 
   * @return json
   */
  public function getByID($id)
  {
    return $this->model->getById($id, $this->relationCol);
  }

  /**
   * Get specific blog by Slug
   * 
   * @param int $id
   * 
   * @return json
   */
  public function getBySlug($slug)
  {
    return $this->model->getByColumns([['slug', $slug], ['is_published', 1]], $this->relationCol);
  }

  /**
   * Get recent blog except id
   * 
   * @param int $id
   * 
   * @return json
   */
  public function getRecentBlog($id)
  {
    return $this->model->getByColumns([['id', '!=', $id], ['is_published', 1]], $this->relationCol, 'created_at', 'DESC', 5);
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
    $data = $this->blogRepo->storeRequest($request);
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
    $data = $this->blogRepo->storeRequest($request);
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
