<?php

namespace App\Controllers;

use App\Models\WorkModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Libraries\FileUpload;

class WorkController extends BaseController
{
    protected $workModel;
    protected $categoryModel;
    protected $userModel;
    protected $fileUpload;

    public function __construct()
    {
        $this->workModel = new WorkModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        $this->fileUpload = new FileUpload();
    }

    public function show($slug)
    {
        $work = $this->workModel->getWorkBySlug($slug);
        
        if (!$work) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Karya tidak ditemukan');
        }

        // Increment views
        $this->workModel->incrementViews($work['id']);
        
        // Get related works
        $relatedWorks = $this->workModel->getRelatedWorks($work['category_id'], $work['id'], 4);

        return view('works/show', [
            'work' => $work,
            'relatedWorks' => $relatedWorks,
            'title' => $work['title'],
            'description' => substr(strip_tags($work['description']), 0, 160),
        ]);
    }

    public function create()
    {
        $authCheck = $this->requireAuth();
        if ($authCheck) return $authCheck;

        $categories = $this->categoryModel->getActiveCategories();
        $years = range(date('Y'), date('Y') - 10);

        return view('works/create', [
            'categories' => $categories,
            'years' => $years,
            'title' => 'Unggah Karya Baru',
        ]);
    }

    public function store()
    {
        $authCheck = $this->requireAuth();
        if ($authCheck) return $authCheck;

        $data = [
            'user_id' => $this->session->get('user_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'year' => $this->request->getPost('year'),
            'category_id' => $this->request->getPost('category_id'),
            'file_type' => $this->request->getPost('file_type'),
        ];

        // External link dapat diisi apapun tipe file nya
        $externalLink = $this->request->getPost('external_link');
        if (!empty($externalLink)) {
            $data['external_link'] = $externalLink;
            // Generate thumbnail for external link
            $data['thumbnail'] = $this->fileUpload->generateLinkThumbnail($externalLink);
        }

        // Handle file upload jika ada file
        $file = $this->request->getFile('file');
        
        if ($file && $file->isValid()) {
            $uploadResult = $this->fileUpload->upload($file, $data['category_id']);
            
            if ($uploadResult['success']) {
                $data['file_path'] = $uploadResult['file_path'];
                $data['thumbnail'] = $uploadResult['thumbnail'];
                $data['file_size'] = $uploadResult['file_size'];
                $data['mime_type'] = $uploadResult['mime_type'];
            } else {
                return redirect()->back()->with('error', $uploadResult['message'])->withInput();
            }
        } else if ($data['file_type'] === 'file' && empty($externalLink)) {
            // Jika tipe file upload dan tidak ada external link, wajib upload file
            return redirect()->back()->with('error', 'File wajib diunggah atau isi external link')->withInput();
        } else if ($data['file_type'] === 'link' && empty($externalLink)) {
            // Jika tipe file link dan tidak ada external link, wajib isi link
            return redirect()->back()->with('error', 'Link eksternal wajib diisi')->withInput();
        }

        if ($this->workModel->insert($data)) {
            return redirect()->to('/karya-saya')->with('success', 'Karya berhasil diunggah');
        }

        return redirect()->back()->with('errors', $this->workModel->errors())->withInput();
    }

    public function edit($id)
    {
        $authCheck = $this->requireAuth();
        if ($authCheck) return $authCheck;

        $work = $this->workModel->find($id);
        
        if (!$work || $work['user_id'] != $this->session->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Karya tidak ditemukan');
        }

        $categories = $this->categoryModel->getActiveCategories();
        $years = range(date('Y'), date('Y') - 10);

        return view('works/edit', [
            'work' => $work,
            'categories' => $categories,
            'years' => $years,
            'title' => 'Edit Karya - ' . $work['title'],
        ]);
    }

    public function update($id)
    {
        $authCheck = $this->requireAuth();
        if ($authCheck) return $authCheck;

        $work = $this->workModel->find($id);
        
        if (!$work || $work['user_id'] != $this->session->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Karya tidak ditemukan');
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'year' => $this->request->getPost('year'),
            'category_id' => $this->request->getPost('category_id'),
        ];

        // Use the existing file_type if not provided in the request
        $fileType = $this->request->getPost('file_type');
        if ($fileType) {
            $data['file_type'] = $fileType;
        } else {
            $data['file_type'] = $work['file_type']; // Use existing file_type from the database
        }

        // Handle external link
        $externalLink = $this->request->getPost('external_link');
        if (!empty($externalLink) && $externalLink !== $work['external_link']) {
            $data['external_link'] = $externalLink;
            $data['thumbnail'] = $this->fileUpload->generateLinkThumbnail($externalLink);
        }

        // Handle file replacement if new file uploaded
        $file = $this->request->getFile('file');
        $fileIsValid = !empty($file) && $file->isValid();
        
        if ($fileIsValid) {
            // Delete old file
            if ($work['file_path']) {
                $this->fileUpload->deleteFile($work['file_path'], $work['thumbnail']);
            }

            $uploadResult = $this->fileUpload->upload($file, $data['category_id']);
            
            if ($uploadResult['success']) {
                $data['file_path'] = $uploadResult['file_path'];
                $data['thumbnail'] = $uploadResult['thumbnail'];
                $data['file_size'] = $uploadResult['file_size'];
                $data['mime_type'] = $uploadResult['mime_type'];
            } else {
                return redirect()->back()->with('error', $uploadResult['message'])->withInput();
            }
        }
        
        // If we're updating a work that already has a file path or external link, we don't need to validate
        $hasExistingFile = !empty($work['file_path']) || !empty($work['external_link']);
        
        // Only validate if there's no existing file and no new file/link is provided
        if ($data['file_type'] === 'file' && !$hasExistingFile && !$fileIsValid && empty($externalLink)) {
            return redirect()->back()->with('error', 'Harap unggah file atau berikan link eksternal')->withInput();
        } else if ($data['file_type'] === 'link' && empty($externalLink) && empty($work['external_link'])) {
            return redirect()->back()->with('error', 'Link eksternal wajib diisi')->withInput();
        }

        if ($this->workModel->update($id, $data)) {
            return redirect()->to('/karya-saya')->with('success', 'Karya berhasil diperbarui');
        }

        return redirect()->back()->with('errors', $this->workModel->errors())->withInput();
    }

    public function delete($id)
    {
        $authCheck = $this->requireAuth();
        if ($authCheck) return $authCheck;

        $work = $this->workModel->find($id);
        
        if (!$work || $work['user_id'] != $this->session->get('user_id')) {
            return $this->jsonResponse(['error' => 'Karya tidak ditemukan'], 404);
        }

        // Delete files
        if ($work['file_path']) {
            $this->fileUpload->deleteFile($work['file_path'], $work['thumbnail']);
        }

        if ($this->workModel->delete($id)) {
            return $this->jsonResponse(['success' => 'Karya berhasil dihapus']);
        }

        return $this->jsonResponse(['error' => 'Gagal menghapus karya'], 500);
    }

    public function myWorks()
    {
        $authCheck = $this->requireAuth();
        if ($authCheck) return $authCheck;

        $userId = $this->session->get('user_id');
        $perPage = 12;
        $page = $this->request->getGet('page') ?? 1;

        $builder = $this->workModel->getWorksWithDetails(['user_id' => $userId]);
        $works = $builder->paginate($perPage, 'default', $page);
        $pager = $this->workModel->pager;

        $stats = $this->userModel->getUserStats($userId);

        return view('works/my_works', [
            'works' => $works,
            'pager' => $pager,
            'stats' => $stats,
            'title' => 'Karya Saya',
        ]);
    }
}