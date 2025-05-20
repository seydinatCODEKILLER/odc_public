<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5.0.0-beta.1/daisyui.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.min.css"
        rel="stylesheet" />
    <title>Document</title>
</head>

<body class="flex items-center min-h-screen inset-0 bg-gradient-to-r from-indigo-50/50 to-white">
    <?php require_once ROOT_PATH . "/views/components/sidebar.php"; ?>
    <div class="w-full flex flex-col lg:ml-56 h-full">
        <?php require_once ROOT_PATH . "/views/components/header.php"; ?>
        <?= $content ?>
    </div>
    <script src="assets/javascript/notif.js"></script>
</body>

</html>