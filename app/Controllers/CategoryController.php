<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\WorkModel;

class CategoryController extends BaseController
{
    protected $categoryModel;
    protected $workModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->workModel = new WorkModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->getCategoryWithWorksCount();

        return view('categories/index', [
            'categories' => $categories,
            'title' => 'Semua Kategori',
        ]);
    }

    public function show($slug)
    {
        $category = $this->categoryModel->getCategoryBySlug($slug);
        
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $perPage = 12;
        $page = $this->request->getGet('page') ?? 1;
        
        $filters = [
            'category' => $slug,
            'year' => $this->request->getGet('year'),
            'search' => $this->request->getGet('search'),
            'order_by' => $this->request->getGet('order_by') ?? 'created_at',
            'order_dir' => $this->request->getGet('order_dir') ?? 'DESC',
        ];

        $builder = $this->workModel->getWorksWithDetails($filters);
        $works = $builder->paginate($perPage, 'default', $page);
        $pager = $this->workModel->pager;

        $yearsData = $this->workModel->getAvailableYears();
        
        // Perbaikan untuk menangani tahun dari database yang berbeda
        $years = [];
        if (is_array($yearsData)) {
            if (isset($yearsData[0]) && is_array($yearsData[0])) {
                // Format untuk SQLite dengan array multidimensi
                foreach ($yearsData as $yearData) {
                    $years[] = $yearData['year'];
                }
            } else {
                // Format untuk MySQL dengan array tunggal
                $years = $yearsData;
            }
        }

        return view('categories/show', [
            'category' => $category,
            'works' => $works,
            'pager' => $pager,
            'years' => $years,
            'filters' => $filters,
            'title' => 'Kategori ' . $category['name'],
        ]);
    }
}