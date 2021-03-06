<?php 

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;


class AuthSuperAdmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('ewsAdminRole'))
        {
            return redirect()
                ->to('/superadmin/login');
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}