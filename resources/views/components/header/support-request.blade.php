<div class="row">
    <div class="col-12">
        <div class="card {{$collapseCard}}">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
                <div class="card-tools">
                    {{$tool}}
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-{{$collapseButton}}"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="container-sm">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2">
                        @foreach ($request as $value)
                            <h6>Department : {{ $value->DepartmentName }}</h6>
                            <h6>Amount : {{ $value->Amount }}</h6>
                            <h6>at Site : {{ $value->AtSite }}</h6>
                            <h6>Type : {{ $value->Type }}</h6>
                            <h6>Remark : {{ $value->Remark }}</h6>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
