@extends('layout')

@section('mtitle')
    {{ $post->title }}
@endsection

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>

    {{-- <img src="{{ asset($post->image->path) }}" > --}}
    {{-- <img src="{{ Storage::url(asset($post->image->path)) }}" > --}}
    {{-- <img src="{{ $post->image->url() }}" > --}}

    {{-- <p>Added: {{ $post->created_at->diffForHumans() }}</p> --}}
    <x-updated :date="$post->created_at->diffForHumans()" :name="$post->user->name"/>
    <x-updated :date="$post->updated_at->diffForHumans()" :name="$post->user->name">
        Updated
    </x-updated>

    <x-tags :tags="$post->tags" />

    @if((new Carbon\Carbon())->diffInMinutes($post->created_at) < 5)
        @component('badge', ['type'=> 'success'])
            NEW
        @endcomponent

        {{-- If we register the badge component in AppServiceProvider boot()
        Blade::component('components.badge', 'badge');
        then we can use 
        @badge(['type'=> 'success'])
            NEW
        @endbadge --}}
    @endif

    <h4>Comments</h4>

    @forelse($post->comments as $comment)
        <p>
            {{ $comment->content }} 
        </p>
        
        {{-- <p class="text-muted">
            added {{ $comment->created_at->diffForHumans() }}
        </p> --}}
        <x-updated :date="$comment->created_at->diffForHumans()" :name="$comment->user->name"/>

    @empty
        <p>No comments</p>
    @endforelse
@endsection