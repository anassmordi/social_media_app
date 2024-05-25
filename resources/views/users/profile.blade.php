@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('users.show', $user) }}" class="list-group-item list-group-item-action active">Profile</a>
            <a href="{{ route('users.followers', $user) }}" class="list-group-item list-group-item-action">Followers</a>
            <a href="{{ route('users.following', $user) }}" class="list-group-item list-group-item-action">Following</a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header fw-semibold">Profile</div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ $user->profile_image ? asset($user->profile_image) : asset('images/default_profile_image.png') }}" alt="Profile Image" class="rounded-circle" style="width: 140px; height: 140px; object-fit: cover;">
                    <div class="ms-3">
                        <h3>{{ $user->full_name }}</h3>
                        <p class="text-muted">{{ '@' . $user->username }}</p>
                        @if ($isFollowing)
                            <form method="POST" action="{{ route('profile.unfollow', $user->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Unfollow</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('profile.follow', $user->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm follow-btn">Follow</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header fw-semibold">Posts</div>
                    <div class="card-body">
                        @foreach ($posts as $post)
                            <div class="card mb-3 post-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between user-info-border pb-2 mb-3">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $post->user->profile_image ? asset($post->user->profile_image) : asset('images/default_profile_image.png') }}" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;" loading="lazy">
                                            <div class="user-text">
                                                <div class="full-name"><strong>{{ $post->user->full_name }}</strong></div>
                                                <div class="username">{{ '@' . $post->user->username }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-2">{{ $post->content }}</p>
                                    @if ($post->post_image)
                                        <img src="{{ asset($post->post_image) }}" alt="Post Image" class="img-fluid post-img" loading="lazy">
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
    </div>
</div>

<style>
    .post-img {
        width: 300px; /* Set your desired width */
        height: 300px; /* Set your desired height */
        object-fit: contain; /* Ensure the whole image is visible */
        background-color: black; /* Black background to fill empty space */
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

    .text-muted {
        color: #6c757d !important;
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

    .username-link {
        color: inherit;
        text-decoration: none;
    }

    .username-link:hover {
        color: inherit;
        text-decoration: none;
    }
    .user-info-border {
        border-bottom: 1px solid #ddd; /* Add a light border */
    }

    body.dark-mode .user-info-border {
        border-bottom: 1px solid #555; /* Adjust the border color for dark mode */
    }
    .user-text {
        display: inline-block;
        vertical-align: top;
        margin-left: 10px;
    }

    .full-name {
        font-size: 1.1rem; /* Larger font size for full name */
    }

    .username {
        font-size: 0.85rem; /* Smaller font size for username */
        color: #6c757d; /* Grey color for the username to make it less prominent */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var body = document.body;
        var followButtons = document.querySelectorAll('.follow-btn');

        function updateFollowButtons() {
            if (body.classList.contains('dark-mode')) {
                followButtons.forEach(function (button) {
                    button.classList.add('btn-dark');
                    button.classList.remove('btn-primary');
                });
            } else {
                followButtons.forEach(function (button) {
                    button.classList.add('btn-primary');
                    button.classList.remove('btn-dark');
                });
            }
        }

        // Update buttons on page load
        updateFollowButtons();

        // Monitor changes to the class list of the body element
        var observer = new MutationObserver(updateFollowButtons);
        observer.observe(body, { attributes: true, attributeFilter: ['class'] });
    });
</script>
@endsection
