@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <span class="text-normal">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-link"> Register</a>
            </div>
            
        </div>
    </div>
</div>
@endsection



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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('error'))
        setTimeout(function() {
            var alert = document.querySelector('.alert');
            if (alert) {
                var fadeEffect = setInterval(function () {
                    if (!alert.style.opacity) {
                        alert.style.opacity = 1;
                    }
                    if (alert.style.opacity > 0) {
                        alert.style.opacity -= 0.1;
                    } else {
                        clearInterval(fadeEffect);
                        alert.remove();
                    }
                }, 50);
            }
        }, 5000); // Adjust the time to 5000 milliseconds (5 seconds)
        @endif
    });
</script>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
