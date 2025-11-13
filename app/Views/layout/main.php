<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?? 'POS Apotek' ?></title>
    <link href="/css/tailwind.css" rel="stylesheet">
    <link href="<?= base_url('css/output.css') ?>" rel="stylesheet">

</head>
<body class="bg-gray-100 min-h-screen">


<?= $this->include('layout/navbar') ?>
<div class="flex">
    <!-- navbar -->
     
    <!-- Main Content -->
    <main class="flex-1 p-6">
        <?= $this->renderSection('content') ?>
    </main>
</div>

</body>
</html>
