<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'slug', 'description', 'icon', 'is_active'];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'slug' => 'permit_empty|alpha_dash|is_unique[categories.slug,id,{id}]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama kategori wajib diisi',
            'min_length' => 'Nama minimal 3 karakter',
            'max_length' => 'Nama maksimal 100 karakter',
        ],
        'slug' => [
            'alpha_dash' => 'Slug hanya boleh berisi huruf, angka, dash dan underscore',
            'is_unique' => 'Slug sudah digunakan',
        ],
    ];

    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (empty($data['data']['slug']) && !empty($data['data']['name'])) {
            $data['data']['slug'] = url_title($data['data']['name'], '-', true);
        }
        return $data;
    }

    public function getActiveCategories()
    {
        return $this->where('is_active', true)
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    public function getCategoryWithWorksCount()
    {
        return $this->select('categories.*, COUNT(works.id) as works_count')
            ->join('works', 'works.category_id = categories.id AND works.status = "published"', 'left')
            ->where('categories.is_active', true)
            ->groupBy('categories.id')
            ->orderBy('categories.name', 'ASC')
            ->findAll();
    }

    public function getCategoryBySlug($slug)
    {
        return $this->where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }
}