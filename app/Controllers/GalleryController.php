<?php

namespace App\Controllers;

use App\Models\WorkModel;
use App\Models\CategoryModel;

class GalleryController extends BaseController
{
    protected $workModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->workModel = new WorkModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $perPage = 12;
        $page = $this->request->getGet('page') ?? 1;
        
        $filters = [
            'category' => $this->request->getGet('category'),
            'year' => $this->request->getGet('year'),
            'search' => $this->request->getGet('search'),
            'order_by' => $this->request->getGet('order_by') ?? 'created_at',
            'order_dir' => $this->request->getGet('order_dir') ?? 'DESC',
        ];

        $builder = $this->workModel->getWorksWithDetails($filters);
        $works = $builder->paginate($perPage, 'default', $page);
        $pager = $this->workModel->pager;

        $categories = $this->categoryModel->getActiveCategories();
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

        return view('gallery/index', [
            'works' => $works,
            'pager' => $pager,
            'categories' => $categories,
            'years' => $years,
            'filters' => $filters,
            'title' => 'Galeri Karya',
        ]);
    }

    public function filter()
    {
        // Check if request is AJAX
        if (!$this->isAjaxRequest()) {
            return redirect()->to('/galeri');
        }

        $perPage = 12;
        $page = $this->request->getGet('page') ?? 1;
        
        $filters = [
            'category' => $this->request->getGet('category'),
            'year' => $this->request->getGet('year'),
            'search' => $this->request->getGet('search'),
            'order_by' => $this->request->getGet('order_by') ?? 'created_at',
            'order_dir' => $this->request->getGet('order_dir') ?? 'DESC',
        ];

        $builder = $this->workModel->getWorksWithDetails($filters);
        $works = $builder->paginate($perPage, 'default', $page);
        $pager = $this->workModel->pager;

        // Make sure we have all necessary data for rendering thumbnails
        foreach ($works as &$work) {
            // Convert description to string if it's an object
            if (is_object($work['description'])) {
                $work['description'] = (string)$work['description'];
            }
            
            // Ensure views is a number
            if (!isset($work['views']) || !is_numeric($work['views'])) {
                $work['views'] = 0;
            }
        }

        return $this->jsonResponse([
            'works' => $works,
            'pagination' => $pager->links('default', 'custom_pagination'),
            'total' => $pager->getTotal(),
        ]);
    }
}