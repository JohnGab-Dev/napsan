<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title == ''? "NAPSAN Pharmacy" : $title?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imgs/napsan_logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px) translateX(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0) translateX(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-slate-100 font-medium">


