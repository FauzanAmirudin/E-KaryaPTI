<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'email', 'password', 'role', 'is_active'];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama lengkap wajib diisi',
            'min_length' => 'Nama minimal 3 karakter',
            'max_length' => 'Nama maksimal 255 karakter',
        ],
        'email' => [
            'required' => 'Email wajib diisi',
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah terdaftar',
        ],
        'password' => [
            'required' => 'Password wajib diisi',
            'min_length' => 'Password minimal 6 karakter',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    public function getUserWorks($userId, $limit = null)
    {
        $builder = $this->db->table('works w')
            ->select('w.*, c.name as category_name, c.slug as category_slug')
            ->join('categories c', 'c.id = w.category_id')
            ->where('w.user_id', $userId)
            ->where('w.status', 'published')
            ->orderBy('w.created_at', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }

    public function getUserStats($userId)
    {
        $works = $this->db->table('works')
            ->select('COUNT(*) as total_works, category_id, c.name as category_name')
            ->join('categories c', 'c.id = works.category_id')
            ->where('user_id', $userId)
            ->where('status', 'published')
            ->groupBy('category_id')
            ->get()
            ->getResultArray();

        $totalViews = $this->db->table('works')
            ->selectSum('views')
            ->where('user_id', $userId)
            ->where('status', 'published')
            ->get()
            ->getRow()
            ->views ?? 0;

        return [
            'total_works' => array_sum(array_column($works, 'total_works')),
            'total_views' => $totalViews,
            'works_by_category' => $works,
        ];
    }
}