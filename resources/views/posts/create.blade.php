@extends('layout')

@section('mtitle')
    Create Post
@endsection

@section('content')
    <form action="{{ route('posts.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        @include('posts._form')

        <button type="submit" class="btn btn-primary btn-block">Create Post</button>
    </form>
@endsection