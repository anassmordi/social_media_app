@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Register</div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                        @error('full_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Birth Date</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                        @error('birth_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image">
                        @error('profile_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <span class="text-normal">Already have an account?</span> <a href="{{ route('login') }}" class="text-link" style="text-decoration: none">Login</a>
            </div>
        </div>
    </div>
</div>
<style>
    .text-normal {
        color: #000; /* Default text color for light mode */
    }

    body.dark-mode .text-link,
    body.dark-mode .text-normal {
        color: #ccc; /* Light text color suitable for dark backgrounds */
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    body.dark-mode .btn-primary {
        background-color: #333;
        border-color: #555;
    }
</style>



@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const toggleThemeElements = () => {
        const body = document.body;
        const textLinks = document.querySelectorAll('.text-link');
        const textNormals = document.querySelectorAll('.text-normal');
        const loginButton = document.querySelector('.btn-primary');

        // Toggle dark mode classes for links and normal text
        textLinks.forEach(link => {
            link.classList.toggle('dark-mode', body.classList.contains('dark-mode'));
        });
        textNormals.forEach(text => {
            text.classList.toggle('dark-mode', body.classList.contains('dark-mode'));
        });

        // Toggle button styles for dark mode
        if (body.classList.contains('dark-mode')) {
            loginButton.classList.remove('btn-primary');
            loginButton.classList.add('btn-dark');
        } else {
            loginButton.classList.remove('btn-dark');
            loginButton.classList.add('btn-primary');
        }
    };

    // Call this function to apply the correct styles on load
    toggleThemeElements();
});
</script>
