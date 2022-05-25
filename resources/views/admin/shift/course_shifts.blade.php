@foreach($shifts as $shift)
<option value="{{ $shift->id }}">{{ $shift->name }}</option>
@endforeach