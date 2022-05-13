<form action="{{url($action)}}" method="post">
{{csrf_field()}}
    <input type="hidden" name="process_id" value="{{$process_id}}"/>
    <input type="hidden" name="process_type" value="{{$process_type}}"/>
    <input type="hidden" name="level" value="{{$level}}"/>
    <input type="hidden" name="approval" value="APPROVE"/>
    <button type="submit" class="btn btn-success green darken-1">{{$button_label ?? 'Approve'}}</button>

</form>