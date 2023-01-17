@foreach($menuFooters as $category)
    @if($category->parent_id)
    <option value="{{ $category->id }}"@if(isset($dataTypeContent->category_id) && $dataTypeContent->category_id == $category->id) selected="selected"@endif>{{ $category->title }}</option>
    @endif
    @endforeach