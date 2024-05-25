@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">Profile</a>
            <a href="{{ route('profile.followers') }}" class="list-group-item list-group-item-action">Followers</a>
            <a href="{{ route('profile.following') }}" class="list-group-item list-group-item-action">Following</a>
            <a href="{{ route('profile.posts') }}" class="list-group-item list-group-item-action">Posts</a>
            <a href="{{ route('profile.findFriends') }}" class="list-group-item list-group-item-action active">Find Friends</a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header fw-semibold">Find Friends</div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($friends as $friend)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('users.show', $friend->id) }}" class="username-link">
                                    <img src="{{ $friend->profile_image ? asset($friend->profile_image) : asset('images/default_profile_image.png') }}"
                                        alt="Profile" class="rounded-circle"
                                        style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;"
                                        loading="lazy">
                                    <strong>{{ '@' . $friend->username }}</strong>
                                </a>
                            </div>
                            <form method="POST" action="{{ route('profile.follow', $friend->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm follow-btn">Follow</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .username-link {
        color: inherit;
        text-decoration: none;
    }

    .username-link:hover {
        color: inherit;
        text-decoration: none;
    }

    .dark-mode .follow-btn {
        background-color: #333;
        border-color: #555;
        color: #ffffff;
    }

    .dark-mode .btn-primary:hover {
        background-color: #555;
        border-color: #777;
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
