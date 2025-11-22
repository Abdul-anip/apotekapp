<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userRole = $session->get('role');

        // Jika ada argument (role yang diizinkan)
        if ($arguments) {
            $allowedRoles = is_array($arguments) ? $arguments : [$arguments];

            // Jika role user tidak ada di daftar yang diizinkan
            if (!in_array($userRole, $allowedRoles)) {
                return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}