<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
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
        .small {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Project
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ URL('/projects') }}">Index</a>
                                @role('planner|admin')
                                    <a class="dropdown-item" href="{{ URL('/projects/create') }}">Create</a>
                                @endrole
                            </div>
                        </li>
                        @role('admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            PM Order
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ URL('/pmorders/1/index') }}">Index</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Cost
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ URL('/costrates') }}">Cost Rate</a>
                                @role('planner|head_engineering|admin')
                                    <a class="dropdown-item" href="{{ URL('/costrates/create') }}">Create Cost Rate</a>
                                @endrole
                            </div>
                        </li>
                        @endrole
                        @role('site_engineer|head_engineering|admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Spare Part
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ URL('/spareparts') }}">Index</a>
                                    <a class="dropdown-item" href="{{ URL('/spareparts/create') }}">Create</a>
                                </div>
                            </li>
                        @endrole
                        @role('store_keeper|supervisor|foreman|admin|head_store_keeper')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tool
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ URL('/tool_catagories') }}">Catagory</a>
                                </div>
                            </li>
                        @endrole
                        @role('store_keeper|supervisor|foreman|admin|head_store_keeper')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Consumable
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ URL('/consumables') }}">Index</a>
                                </div>
                            </li>
                        @endrole
                        @role('area_manager|foreman|admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Risk
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ URL('/hazards') }}">Hazard</a>
                                    <a class="dropdown-item" href="{{ URL('/QSH_departments/2') }}">Quality Safety and Health (หบน-ธ.)</a>
                                </div>
                            </li>
                        @endrole
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Item
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ URL('/items') }}">Index</a>
                                @role('admin|head_engineering|planner')
                                    <a class="dropdown-item" href="{{ URL('/locations') }}">Location</a>
                                    <a class="dropdown-item" href="{{ URL('/products') }}">Product</a>
                                    <a class="dropdown-item" href="{{ URL('/machines') }}">Machine</a>
                                    <a class="dropdown-item" href="{{ URL('/systems') }}">System</a>
                                    <a class="dropdown-item" href="{{ URL('/equipment') }}">Equipment</a>
                                    <a class="dropdown-item" href="{{ URL('/scopes') }}">Scope</a>
                                @endrole
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Employee
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ URL('/employees') }}">Index</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            On the Job Training
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ URL('/onthejobtrainings') }}">Index</a>
                                <a class="dropdown-item" href="{{ URL('/evaluation') }}">Evaluation</a>
                            </div>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container-sm py-4">
            <h3>PM Order</h3>
            <div class="container-sm">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                    @yield('header')
                </div>
            </div>
            <div class="text-right">
                <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">@yield('createbtn')</button> <!-- -->
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm" id="data_table">
                    <thead>
                        @yield('tblhead')
                    </thead>
                </table>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New @yield('name')</h4> <!-- -->
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="create_form" class="form-horizontal">
                    @csrf
                    @yield('form')
                </form>
            </div>
        </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmation</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 class="text-center" style="margin:0;">Are you sure you want to remove this data?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        $('#data_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
            url: "", //
        },
            columns: [ //
                {
                    data: 'SuperPMOrder',
                    name: 'SuperPMOrder'
                },
                {
                    data: 'PMOrder',
                    name: 'PMOrder'
                },
                {
                    data: 'PMOrderName',
                    name: 'PMOrderName',
                    orderable: false
                },
                {
                    data: 'Remark',
                    name: 'Remark',
                    orderable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ]
        });

    $('#create_record').click(function(){
            $('#create_form')[0].reset();
        $('.modal-title').text('Add PM Order'); //
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#form_result').html('');
        $('#formModal').modal('show');
    });

    $('#create_form').on('submit', function(event){
        event.preventDefault();
        var action_url = '';

        if($('#action').val() == 'Add')
        {
            action_url = "{{ url('pmorders') }}"; //
        }

        if($('#action').val() == 'Edit')
        {
            action_url = "{{ url('pmorders/update') }}"; //
        }

        $.ajax({
            url: action_url,
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                var html = '';
                if(data.errors)
                {
                    html = '<div class="alert alert-danger">';
                    for(var count = 0; count < data.errors.length; count++)
                    {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if(data.success)
                {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#create_form')[0].reset();
                    $('#data_table').DataTable().ajax.reload();
                }
                $('#form_result').html(html);
            }
        });
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).attr('id');
        $('#form_result').html('');
        $.ajax({
            url :"{{ url('/pmorders/') }}"+id+"/edit", //
            dataType:"json",
            success:function(data)
            {
                $('#p_m_order_id<x-data-table.edit-value-script name="p_m_order_id); //
                $('#PMOrder<x-data-table.edit-value-script name="PMOrder);
                $('#PMOrderName<x-data-table.edit-value-script name="PMOrderName);
                $('#Remark<x-data-table.edit-value-script name="Remark);

                PM Order'); //
                $('#action_button').val('Edit');
                $('#action').val('Edit');
                $('#formModal').modal('show');
            }
        })
    });

    var user_id;

    $(document).on('click', '.delete', function(){
        user_id = $(this).attr('id');
        $('.modal-title').text('Confirmation');
            $('#ok_button').text('Delete');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function(){
        $.ajax({
            url:"/pmorders/destroy/"+user_id, //
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
            },
            success:function(data)
            {
                setTimeout(function(){
                    $('#confirmModal').modal('hide');
                    $('#data_table').DataTable().ajax.reload();
                    alert('Data Deleted');
                }, 2000);
            }
        })
        });
    });
</script>
