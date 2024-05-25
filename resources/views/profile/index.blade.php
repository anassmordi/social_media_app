@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('profile') }}" class="list-group-item list-group-item-action active">Profile</a>
            <a href="{{ route('profile.followers') }}" class="list-group-item list-group-item-action">Followers</a>
            <a href="{{ route('profile.following') }}" class="list-group-item list-group-item-action">Following</a>
            <a href="{{ route('profile.posts') }}" class="list-group-item list-group-item-action">Posts</a>
            <a href="{{ route('profile.findFriends') }}" class="list-group-item list-group-item-action">Find Friends</a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header fw-semibold">Profile</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $user->full_name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Birth Date</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $user->birth_date }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        @if ($user->profile_image)
                            <div class="mb-3">
                                <img id="currentProfileImage" src="{{ asset($user->profile_image) }}" alt="Profile Image" class="rounded-circle" style="width: 140px; height: 140px; object-fit: cover;">
                            </div>
                        @endif
                        <div class="mb-3 position-relative">
                            <img id="previewProfileImage" src="#" alt="New Profile Image" class="rounded-circle" style="width: 140px; height: 140px; object-fit: cover; display: none;">
                            <button type="button" class="btn-close-custom position-absolute top-0 start-0 translate-middle" aria-label="Close" onclick="cancelImageUpload()" style="display: none;"></button>
                        </div>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" onchange="previewImage(event)">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-close-custom {
        background-color: transparent;
        border: none;
        color: red;
        font-size: 1.5rem;
        line-height: 1;
    }

    .btn-close-custom:hover,
    .btn-close-custom:focus {
        color: darkred;
    }

    .btn-close-custom::before {
        content: '×';
    }

    body.dark-mode .text-muted {
        color: #cccccc !important;
    }

    .username-link {
        color: inherit;
        text-decoration: none;
    }

    .username-link:hover {
        color: inherit;
        text-decoration: none;
    }

    body.dark-mode .username-link {
        color: #ffffff;
    }

    .list-group-item.active {
        background-color: #0d6efd; /* Default active background for light mode */
        border-color: #0d6efd; /* Default active border for light mode */
        color: #fff;
    }

    body.dark-mode .list-group-item.active {
        background-color: #333;
        border-color: #555;
        color: #fff;
    }
    body.dark-mode .btn-primary,
        body.dark-mode .btn-dark {
            background-color: #333;
            border-color: #555;
        }
</style>

<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('previewProfileImage');
            var currentImage = document.getElementById('currentProfileImage');
            var closeButton = document.querySelector('.btn-close-custom');
            preview.src = reader.result;
            preview.style.display = 'block';
            closeButton.style.display = 'block';
            if (currentImage) {
                currentImage.style.display = 'none';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }

    function cancelImageUpload() {
        var preview = document.getElementById('previewProfileImage');
        var input = document.getElementById('profile_image');
        var closeButton = document.querySelector('.btn-close-custom');
        var currentImage = document.getElementById('currentProfileImage');
        preview.src = '#';
        preview.style.display = 'none';
        closeButton.style.display = 'none';
        input.value = '';
        if (currentImage) {
            currentImage.style.display = 'block';
        }
    }
</script>
@endsection
