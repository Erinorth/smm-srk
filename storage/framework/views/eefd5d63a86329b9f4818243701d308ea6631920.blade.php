<div class="form-group">
    <label class="control-label" >{{$title}}</label> <!-- -->
    <div>
        <select class="form-control select2-bootstrap4" name="{{$nameId}}" id="{{$nameId}}">
            {{$slot}}
        </select>
    </div>
</div>