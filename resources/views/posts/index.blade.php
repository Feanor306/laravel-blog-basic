@extends('layout')

@section('mtitle')
    Posts
@endsection

@section('content')
    {{-- @foreach ($posts as $post) --}}
    @forelse ($posts as $post)

        <h3>
            <a class="{{ $post->trashed() ? 'text-muted': ''}}"
                href="{{ route('posts.show', ['post' => $post->id]) }}">
                {{ $post->title }}
            </a>
        </h3>

        {{-- MOVED TO UPDATED COMPONENT --}}
        {{-- <p class="text-muted">
            Added: {{ $post->created_at->diffForHumans() }}
            by {{ $post->user->name }}
        </p> --}}

        @updated(['date' => $post->created_at,'name' => $post->user->name])
        @endupdated

        @tags(['tags' => $post->tags])@endtags

        @if($post->comments_count)
            <p>{{ $post-> comments_count }} comments</p>
        @else
            <p>No comments</p>
        @endif

        {{-- REDUCE AUTH CHECKS USING @auth DIRECTIVE WHEN POSSIBLE --}}
        @auth
            @can('update', $post)
                <a class="btn btn-primary"
                    href="{{ route('posts.edit', ['post' => $post->id]) }}">
                    Edit
                </a>
            @endcan

            @can('delete', $post)
                <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-primary" 
                        type="submit" value="Delete">
                </form>
            @endcan
        @endauth

    @empty
        <p>No posts found</p>
    @endforelse
@endsection