@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">Profile</a>
                <a href="{{ route('profile.followers') }}" class="list-group-item list-group-item-action">Followers</a>
                <a href="{{ route('profile.following') }}" class="list-group-item list-group-item-action">Following</a>
                <a href="{{ route('profile.posts') }}" class="list-group-item list-group-item-action active">Posts</a>
                <a href="{{ route('profile.findFriends') }}" class="list-group-item list-group-item-action">Find Friends</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header fw-semibold">Posts</div>
                <div class="card-body">
                    @foreach ($posts as $post)
                        <div class="card mb-3 post-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between user-info-border pb-2 mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $post->user->profile_image ? asset($post->user->profile_image) : asset('images/default_profile_image.png') }}"
                                            alt="Profile" class="rounded-circle"
                                            style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                        <strong>{{ '@You' }}</strong>
                                    </div>
                                    <form method="POST" action="{{ route('profile.deletePost', $post->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                                <p class="mt-2">{{ $post->content }}</p>
                                @if ($post->post_image)
                                    <img src="{{ asset($post->post_image) }}" alt="Post Image" class="img-fluid post-img">
                                @endif
                                <div class="text-end text-muted" style="font-size: 0.9rem;">
                                    <small>Posted on {{ $post->created_at->format('F j, Y, g:i a') }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .post-img {
            width: 300px;
            /* Set your desired width */
            height: 300px;
            /* Set your desired height */
            object-fit: contain;
            /* Ensure the whole image is visible */
            background-color: black;
            /* Black background to fill empty space */
        }

        .user-info-border {
            border-bottom: 1px solid #ddd;
            /* Add a light border */
        }

        body.dark-mode .user-info-border {
            border-bottom: 1px solid #555;
            /* Adjust the border color for dark mode */
        }

        body.dark-mode .post-card {
            background-color: #1e1e1e;
            border-color: #333;
            color: #ffffff;
        }

        body.dark-mode .post-card .card-body,
        body.dark-mode .post-card .text-end {
            color: #ffffff;
        }

        body.dark-mode .post-card .text-muted {
            color: #cccccc !important;
        }

        body.dark-mode .btn-primary,
        body.dark-mode .btn-dark {
            background-color: #333;
            border-color: #555;
        }

        body.dark-mode .form-control {
            background-color: #333;
            border-color: #555;
            color: #ffffff;
        }

        body.dark-mode .form-control::placeholder {
            color: #aaaaaa;
        }

        .list-group-item.active {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }

        body.dark-mode .list-group-item.active {
            background-color: #333;
            border-color: #555;
            color: #fff;
        }
    </style>
@endsection
