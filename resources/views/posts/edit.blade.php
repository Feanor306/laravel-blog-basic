@extends('layout')

@section('mtitle')
    Create Post
@endsection

@section('content')
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('posts._form')
        
        <button type="submit" class="btn btn-primary btn-block">Update Post</button>
    </form>
@endsection