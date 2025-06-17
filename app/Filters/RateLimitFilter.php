<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RateLimitFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $cache = \Config\Services::cache();
        $key = 'rate_limit_' . $request->getIPAddress();
        
        $attempts = $cache->get($key) ?? 0;
        
        // Allow 60 requests per minute
        if ($attempts >= 60) {
            // Check if request is AJAX
            if ($request->hasHeader('X-Requested-With') && $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
                return service('response')->setJSON([
                    'error' => 'Too many requests. Please try again later.'
                ])->setStatusCode(429);
            }
            
            return redirect()->back()->with('error', 'Terlalu banyak permintaan. Silakan coba lagi nanti.');
        }
        
        $cache->save($key, $attempts + 1, 60);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}