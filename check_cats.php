<?php
// Script to check categories
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
chdir(__DIR__);
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

use App\Models\KategoriModel;

$model = new KategoriModel();
$cats = $model->findAll();

echo "Count: " . count($cats) . "\n";
foreach ($cats as $c) {
    echo "ID: " . $c['id'] . " - Name: " . $c['nama_kategori'] . "\n";
}
