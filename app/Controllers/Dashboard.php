<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['title'] = "Dashboard POS Apotek";
        return view('dashboard', $data);
    }
}
