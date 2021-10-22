<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Merchant extends Controller
{
    public function index()
    {
        $data['title'] = "Merchant Index";
        echo view('templates/header', $data);
        echo view('superadmin/index', $data);
        // echo view('templates/footer', $data);
        
    }

    // public function view($page = 'home')
    // {
    //     if ( ! is_file(APPPATH.'/Views/superadmin/'.$page.'.php')) {
    //         // Whoops, we don't have a page for that!
    //         throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
    //     }
    
    //     $data['title'] = ucfirst($page); // Capitalize the first letter
    
    //     echo view('templates/header', $data);
    //     echo view('navbars/superadmin', $data);
    //     echo view('superadmin/'.$page, $data);
    //     echo view('templates/footer', $data);
    // }
}
