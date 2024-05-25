@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">Profile</a>
            <a href="{{ route('profile.followers') }}" class="list-group-item list-group-item-action">Followers</a>
            <a href="{{ route('profile.following') }}" class="list-group-item list-group-item-action active">Following</a>
            <a href="{{ route('profile.posts') }}" class="list-group-item list-group-item-action">Posts</a>
            <a href="{{ route('profile.findFriends') }}" class="list-group-item list-group-item-action">Find Friends</a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header fw-semibold">Following</div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($following as $follow)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('users.show', $follow->id) }}" class="username-link"><img src="{{ $follow->profile_image ? asset($follow->profile_image) : asset('images/default_profile_image.png') }}"
                                    alt="Profile" class="rounded-circle"
                                    style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                <strong>{{ '@'.$follow->username }}</strong></a>
                            </div>
                            <form method="POST" action="{{ route('profile.unfollow', $follow->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Unfollow</button>
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
