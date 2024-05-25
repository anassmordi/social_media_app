@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card mb-4">
            <div class="card-header fw-semibold">Create Post</div>
            <div class="card-body">
                <form method="POST" action="{{ url('home') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control" name="content" placeholder="What's on your mind?" required></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="file" class="form-control" name="post_image" id="post_image" onchange="previewImage();">
                        <!-- Image preview container -->
                        <div class="mt-2">
                            <img id="image_preview" style="width: 100%; max-height: 300px; display: none;" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
        </div>

        @foreach ($posts as $post)
            <div class="card mb-3 post-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between user-info-border pb-2 mb-3">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('users.show', $post->user) }}" class="username-link">
                                <img src="{{ $post->user->profile_image ? asset($post->user->profile_image) : asset('images/default_profile_image.png') }}"
                                alt="Profile" class="rounded-circle"
                                style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;" loading="lazy">
                                <div class="user-text">
                                    <div class="full-name"><strong>{{ $post->user->full_name }}</strong></div>
                                    <div class="username">{{ '@' . $post->user->username }}</div>
                                </div>
                            </a>
                        </div>
                        <form method="POST" action="{{ route('profile.unfollow', $post->user->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Unfollow</button>
                        </form>
                    </div>
                    <p class="mt-2">{{ $post->content }}</p>
                    @if ($post->post_image)
                        <img src="{{ asset($post->post_image) }}" alt="Post Image" class="img-fluid post-img" loading="lazy" onclick="showImageModal('{{ asset($post->post_image) }}');">
                    @endif
                    <div class="text-end text-muted" style="font-size: 0.9rem;">
                        <small>Posted on {{ $post->created_at->format('F j, Y, g:i a') }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: transparent; border: none;">
            <div class="modal-body p-0">
                <img id="modalImage" src="" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<script>
function previewImage() {
    var input = document.getElementById('post_image');
    var preview = document.getElementById('image_preview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function showImageModal(src) {
    var modalImage = document.getElementById('modalImage');
    modalImage.src = src;
    $('#imageModal').modal('show');
}
</script>

<style>
    .post-img, #image_preview {
        width: 100%; /* Adjust width to 100% to prevent stretching */
        max-height: 300px; /* Maximum height */
        object-fit: contain; /* Ensure the whole image is visible */
        background-color: black; /* Black background to fill empty space */
    }

    .user-info-border {
        border-bottom: 1px solid #ddd; /* Add a light border */
    }

    body.dark-mode .user-info-border {
        border-bottom: 1px solid #555; /* Adjust the border color for dark mode */
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

    /* Modal content with no background and no border */
    .modal-content {
        background: transparent;
        border: none;
    }
</style>
@endsection
