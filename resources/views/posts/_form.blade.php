{{-- SHOW VALIDATION ERRORS --}}
{{-- @if($errors->any())
<ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
@endif --}}
@errors @enderrors

{{-- old('field', 'defaultValue') keeps value between reloads  --}}
<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" 
        class="form-control"
        value="{{ old('title', $post->title ?? null) }}">
</div>

<div class="form-group">
    <label for="content">Content</label>
    <input type="text" name="content" 
        class="form-control"
        value="{{ old('content', $post->content ?? null) }}">
</div>

<div class="form-group">
    <label for="thumbnail">Thumbnail</label>
    <input type="file" name="thumbnail" 
        class="form-control-file">
</div>
