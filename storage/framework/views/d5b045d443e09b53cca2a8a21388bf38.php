<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'SIGERAIMPP'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        *{
            box-sizing: border-box;
        }

        html, body{
            margin:0;
            padding:0;
            width:100%;
            min-height:100%;
            font-family: Arial, sans-serif;
        }

        /* 🔥 SATU BACKGROUND GEDUNG GLOBAL */
        body{
            background: url('<?php echo e(asset('assets/gedung.jpg')); ?>') center/cover no-repeat fixed;
        }

        /* overlay supaya teks kebaca */
        .app-overlay{
            min-height:100vh;
            width:100%;
            background: rgba(255,255,255,.45);
        }

        main{
            width:100%;
        }
    </style>
</head>
<body>

<div class="app-overlay">

    
    <?php echo $__env->yieldContent('header'); ?>

    
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->yieldContent('footer'); ?>

</div>

</body>
</html>
<?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/layouts/app.blade.php ENDPATH**/ ?>