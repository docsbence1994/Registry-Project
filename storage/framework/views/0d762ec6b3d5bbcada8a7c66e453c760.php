<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Naptár</title>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('css/calendar.css')); ?>">
</head>
<body>

    <h1 class="title">Ügyfélfogadási naptár</h1>

    <div id="calendar"></div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="<?php echo e(asset('js/calendar.js')); ?>"></script>

</body>
</html><?php /**PATH C:\Repositories\PHP\registry\resources\views/calendar.blade.php ENDPATH**/ ?>