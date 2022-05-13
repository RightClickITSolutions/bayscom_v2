<form action="{{url($action)}}" method="post">
{{csrf_field()}}
    <input type="hidden" name="process_id" value="{{$process_id}}"/>
    <input type="hidden" name="process_type" value="{{$process_type}}"/>
    <input type="hidden" name="level" value="{{$level}}"/>
    <input type="hidden" name="approval" value="DECLINE"/>
    <button type="submit" class="btn btn-danger red darken-1">{{$button_label ?? 'Decline'}}</button>

</form>