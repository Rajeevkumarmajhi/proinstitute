@foreach($subjects as $subject)
    <option value="{{ $subject->id }}">[ {{ $subject->code }} ] {{ $subject->name }}</option>
@endforeach