<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Smart Maintenance Management</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="top-right links">
                <?php if(Auth::user()): ?>
                    <?php ( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') ); ?>

                    <?php if(config('adminlte.use_route_url', false)): ?>
                        <?php ( $logout_url = $logout_url ? route($logout_url) : '' ); ?>
                    <?php else: ?>
                        <?php ( $logout_url = $logout_url ? url($logout_url) : '' ); ?>
                    <?php endif; ?>

                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-fw fa-power-off"></i>
                        <?php echo e(__('adminlte::adminlte.log_out')); ?>

                    </a>
                    <form id="logout-form" action="<?php echo e($logout_url); ?>" method="POST" style="display: none;">
                        <?php if(config('adminlte.logout_method')): ?>
                            <?php echo e(method_field(config('adminlte.logout_method'))); ?>

                        <?php endif; ?>
                        <?php echo e(csrf_field()); ?>

                    </form>
                <?php endif; ?>
            </div>

            <div class="content">
                <div class="title m-b-md">
                    <?php if(auth()->check() && auth()->user()->hasRole('head_operation|admin|head_engineering|planner|site_engineer|supervisor|foreman|skill|inspector|store_keeper|head_store_keeper|immm|viewer')): ?>
                        <a href=<?php echo e(url('/QSH_schedules')); ?> >Go to Application</a>
                    <?php else: ?>
                        Not Approved yet
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>

<?php /**PATH D:\xampp\htdocs\smm-srk\resources\views/home.blade.php ENDPATH**/ ?>