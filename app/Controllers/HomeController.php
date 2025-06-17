<?php

namespace App\Controllers;

use App\Models\WorkModel;
use App\Models\CategoryModel;

class HomeController extends BaseController
{
    public function index()
    {
        $workModel = new WorkModel();
        $categoryModel = new CategoryModel();

        $featuredWorks = $workModel->getFeaturedWorks(6);
        $latestWorks = $workModel->getLatestWorks(8);
        $categories = $categoryModel->getCategoryWithWorksCount();

        return view('home/index', [
            'featuredWorks' => $featuredWorks,
            'latestWorks' => $latestWorks,
            'categories' => $categories,
        ]);
    }
}