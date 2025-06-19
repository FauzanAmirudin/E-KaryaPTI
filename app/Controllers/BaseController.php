<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['url', 'form', 'html'];
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load custom helper
        helper('custom');

        // Initialize session
        $this->session = \Config\Services::session();
        
        // Clear flash data that might be causing loops
        // Uncomment this for debugging only: $this->session->removeTempdata('_ci_old_input');
        
        // Set CORS headers
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    }

    protected function isLoggedIn()
    {
        return $this->session->get('user_id') !== null;
    }

    protected function getCurrentUser()
    {
        if (!$this->isLoggedIn()) {
            return null;
        }

        $userModel = new \App\Models\UserModel();
        return $userModel->find($this->session->get('user_id'));
    }

    protected function requireAuth()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        return false;
    }

    /**
     * Return JSON response
     *
     * @param array $data Response data
     * @param int $code HTTP status code
     * @return \CodeIgniter\HTTP\Response
     */
    protected function jsonResponse($data, $code = 200)
    {
        return $this->response->setStatusCode($code)->setJSON($data);
    }

    protected function isAjaxRequest()
    {
        return $this->request->hasHeader('X-Requested-With') && 
               $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';
    }
}