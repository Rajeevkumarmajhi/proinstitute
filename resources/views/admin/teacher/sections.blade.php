@foreach($sections as $section)
    <option value="{{ $section->id }}">{{ $section->name }}</option>
@endforeach