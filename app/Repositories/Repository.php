<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository
{
  protected $model;

  public function __construct(Model $model)
  {
    if (!$model instanceof Model)
      throw new \Exception('Repository Error: Model belum didefinisikan', 500);

    $this->model = $model;
  }

  /**
   * Where by columns
   * 
   * @param array     $wheres Where ['column' => 'value']
   * @param string    $orderBy Order data by column
   * @param string    $sort Sorting type ('DESC', 'ASC')
   * @param int       $sort Limit display data
   * @param array     $columns Column to show
   * 
   * @return json
   */
  public function getByColumns($wheres = [], $withs = [], $orderBy = 'created_at', $sort = 'DESC', $limit = 0, $columns = [])
  {
    try {

      $collections = $this->model;

      if (!empty($wheres))
        $collections = $collections->where($wheres);

      if (!empty($withs))
        $collections = $collections->with($withs);

      if (!empty($columns))
        $collections = $collections->select($columns);

      if ($limit > 0)
        $collections = $collections->limit($limit);

      $data = $collections->orderBy($orderBy, $sort)->get();

      return response()->json($data);
    } catch (\Exception $err) {
      return response()->json([
        'status' => $err->getCode(),
        'message' => 'Terjadi kesalahan dalam mengambil data',
        'trace' => $err->getMessage()
      ], 500);
    }
  }

  /**
   * Get all data
   * 
   * @param array     $withs Relationship with Method
   * @param string    $orderBy Order data by column
   * @param string    $sort Sorting type ('DESC', 'ASC')
   * @param int       $sort Limit display data
   * @param array     $columns Columns to show
   * 
   * @return json
   */
  public function getAll($withs = [], $orderBy = 'created_at', $sort = 'DESC', $limit = 0, $columns = [])
  {
    return $this->getByColumns([], $withs, $orderBy, $sort, $limit, $columns);
  }

  /**
   * Get specific data by ID
   * 
   * @param int       $id
   * @param array     $wheres Where ['column' => 'value']
   * @param string    $orderBy Order data by column
   * @param string    $sort Sorting type ('DESC', 'ASC')
   * @param int       $sort Limit display data
   * @param array     $columns Columns to show
   * 
   * @return json
   */
  public function getById($id, $withs = [], $orderBy = 'created_at', $sort = 'DESC', $limit = 0, $columns = [])
  {
    return $this->getByColumns(['id' => $id], $withs, $orderBy, $sort, $limit, $columns);
  }

  /**
   * Create new data
   * 
   * @param array $data Data to store to database
   * 
   * @return json
   */
  public function create($data)
  {
    try {
      $save = $this->model->create($data);
      if (!$save)
        throw new \Exception('Gagal menyimpan data', 403);

      return response()->json([
        'status' => 200,
        'message' => 'Sukses menyimpan data',
        'payload' => $save,
      ]);
    } catch (\Exception $err) {
      return response()->json([
        'status' => $err->getCode(),
        'message' => 'Terjadi kesalahan dalam menyimpan data',
        'trace' => $err->getMessage()
      ], 500);
    }
  }

  /**
   * Update specific data by Columns
   * 
   * @param array   $wheres Where ['column' => 'value']
   * @param array   $data Data to save to database
   * 
   * @return json
   */
  public function updateByColumns($wheres, $data)
  {
    try {
      $collection = $this->model->where($wheres);
      if ($collection->count() <= 0)
        throw new \Exception('Data tidak ditemukan', 404);

      $save = $collection->update($data);
      if (!$save)
        throw new \Exception('Gagal mengubah data', 403);

      return response()->json([
        'status' => 200,
        'message' => 'Sukses mengubah data',
      ]);
    } catch (\Exception $err) {
      return response()->json([
        'status' => $err->getCode(),
        'message' => 'Terjadi kesalahan dalam mengubah data',
        'trace' => $err->getMessage()
      ], 500);
    }
  }

  /**
   * Update specific data by ID
   * 
   * @param int     $id
   * @param array   $data Data to save to database
   * 
   * @return json
   */
  public function updateById($id, $data)
  {
    return $this->updateByColumns(['id' => $id], $data);
  }

  /**
   * Delete specific data by Columns
   * 
   * @param array   $wheres Where ['column' => 'value']
   * 
   * @return json
   */
  public function deleteByColumns($wheres = [])
  {
    try {
      $collection = $this->model->where($wheres);
      if ($collection->count() <= 0)
        throw new \Exception('Data tidak ditemukan', 404);

      $delete = $collection->delete();
      if (!$delete)
        throw new \Exception('Gagal menghapus data', 403);

      return response()->json([
        'status' => 200,
        'message' => 'Sukses menghapus data',
      ]);
    } catch (\Exception $err) {
      return response()->json([
        'status' => $err->getCode(),
        'message' => 'Terjadi kesalahan dalam menghapus data',
        'trace' => $err->getMessage()
      ], 500);
    }
  }

  /**
   * Delete all data by IDs
   * 
   * @param array   $ids Bulk id to delete
   * 
   * @return json
   */
  public function bulkDelete($ids)
  {
    try {
      $delete = $this->model->whereIn('id', explode(',', $ids))->delete();
      if (!$delete)
        throw new \Exception('Gagal menghapus data', 403);

      return response()->json([
        'status' => 200,
        'message' => 'Sukses menghapus data',
      ]);
    } catch (\Exception $err) {
      throw $err;
    }
  }

  /**
   * Delete specific data by ID
   * 
   * @param int   $id
   * 
   * @return json
   */
  public function deleteById($id)
  {
    return $this->deleteByColumns(['id' => $id]);
  }
}
