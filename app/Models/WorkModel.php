<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkModel extends Model
{
    protected $table = 'works';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id', 'category_id', 'title', 'slug', 'description', 'year',
        'file_type', 'file_path', 'external_link', 'thumbnail', 'file_size',
        'mime_type', 'views', 'is_featured', 'status'
    ];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'title' => 'required|min_length[5]|max_length[255]',
        'description' => 'required|min_length[10]',
        'year' => 'required|integer|greater_than[2018]',
        'category_id' => 'required|integer',
        'file_type' => 'required|in_list[file,link]',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul karya wajib diisi',
            'min_length' => 'Judul minimal 5 karakter',
            'max_length' => 'Judul maksimal 255 karakter',
        ],
        'description' => [
            'required' => 'Deskripsi wajib diisi',
            'min_length' => 'Deskripsi minimal 10 karakter',
        ],
        'year' => [
            'required' => 'Tahun wajib dipilih',
            'integer' => 'Tahun harus berupa angka',
            'greater_than' => 'Tahun minimal 2019',
        ],
        'category_id' => [
            'required' => 'Kategori wajib dipilih',
        ],
        'file_type' => [
            'required' => 'Tipe file wajib dipilih',
            'in_list' => 'Tipe file tidak valid',
        ],
    ];

    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (empty($data['data']['slug']) && !empty($data['data']['title'])) {
            $slug = url_title($data['data']['title'], '-', true);
            $originalSlug = $slug;
            $counter = 1;

            while ($this->where('slug', $slug)->first()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $data['data']['slug'] = $slug;
        }
        return $data;
    }

    public function getWorksWithDetails($filters = [])
    {
        $builder = $this->select('works.*, users.name as user_name, categories.name as category_name, categories.slug as category_slug')
            ->join('users', 'users.id = works.user_id')
            ->join('categories', 'categories.id = works.category_id')
            ->where('works.status', 'published');

        if (!empty($filters['category'])) {
            $builder->where('categories.slug', $filters['category']);
        }

        if (!empty($filters['year'])) {
            $builder->where('works.year', $filters['year']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                ->like('works.title', $filters['search'])
                ->orLike('works.description', $filters['search'])
                ->orLike('users.name', $filters['search'])
                ->groupEnd();
        }

        if (!empty($filters['user_id'])) {
            $builder->where('works.user_id', $filters['user_id']);
        }

        $orderBy = $filters['order_by'] ?? 'created_at';
        $orderDir = $filters['order_dir'] ?? 'DESC';
        $builder->orderBy('works.' . $orderBy, $orderDir);

        return $builder;
    }

    public function getFeaturedWorks($limit = 6)
    {
        return $this->select('works.*, users.name as user_name, categories.name as category_name')
            ->join('users', 'users.id = works.user_id')
            ->join('categories', 'categories.id = works.category_id')
            ->where('works.status', 'published')
            ->where('works.is_featured', true)
            ->orderBy('works.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getLatestWorks($limit = 8)
    {
        return $this->select('works.*, users.name as user_name, categories.name as category_name')
            ->join('users', 'users.id = works.user_id')
            ->join('categories', 'categories.id = works.category_id')
            ->where('works.status', 'published')
            ->orderBy('works.created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getWorkBySlug($slug)
    {
        return $this->select('works.*, users.name as user_name, users.id as user_id, categories.name as category_name, categories.slug as category_slug')
            ->join('users', 'users.id = works.user_id')
            ->join('categories', 'categories.id = works.category_id')
            ->where('works.slug', $slug)
            ->where('works.status', 'published')
            ->first();
    }

    public function getRelatedWorks($categoryId, $excludeId, $limit = 4)
    {
        // SQLite tidak mendukung RAND(), gunakan "RANDOM()" sebagai alternatif
        $randomFunction = $this->db->DBDriver === 'SQLite3' ? 'RANDOM()' : 'RAND()';
        
        return $this->select('works.*, users.name as user_name, categories.name as category_name')
            ->join('users', 'users.id = works.user_id')
            ->join('categories', 'categories.id = works.category_id')
            ->where('works.category_id', $categoryId)
            ->where('works.id !=', $excludeId)
            ->where('works.status', 'published')
            ->orderBy($randomFunction)
            ->limit($limit)
            ->findAll();
    }

    public function incrementViews($id)
    {
        return $this->set('views', 'views + 1', false)
            ->where('id', $id)
            ->update();
    }

    public function getAvailableYears()
    {
        // Tambahkan pengecekan database driver untuk kompatibilitas SQLite
        if ($this->db->DBDriver === 'SQLite3') {
            return $this->select('year')
                ->where('status', 'published')
                ->orderBy('year', 'DESC')
                ->groupBy('year')
                ->findAll();
        } else {
            return $this->distinct()
                ->select('year')
                ->where('status', 'published')
                ->orderBy('year', 'DESC')
                ->findColumn('year');
        }
    }
}