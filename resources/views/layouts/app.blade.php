<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <!-- For dark mode icon -->
    <style>
        .app-title {
            font-family: "Poetsen One", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        body.dark-mode ::-webkit-scrollbar-thumb {
            background: #555;
        }

        body.dark-mode ::-webkit-scrollbar-thumb:hover {
            background: #777;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #121212;
            color: #ababab;
        }

        .dark-mode .card,
        .dark-mode .navbar,
        .dark-mode .list-group-item {
            background-color: #1e1e1e;
            border-color: #333;
        }

        .dark-mode .navbar,
        .dark-mode .card-header,
        .dark-mode .card-body,
        .dark-mode .card-title,
        .dark-mode .card-text,
        .dark-mode .list-group-item,
        .dark-mode .navbar-nav .nav-link,
        .dark-mode .dropdown-item,
        .dark-mode .form-control,
        .dark-mode .btn {
            color: #ffffff;
        }

        .dark-mode .navbar-brand {
            color: #ffffff !important;
        }

        .dark-mode .form-control {
            background-color: #333;
            border-color: #555;
        }

        .dark-mode .btn-close-white {
            filter: invert(1);
        }

        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }

        body.dark-mode .text-muted {
            color: #cccccc !important;
        }
    </style>
    <style>
        .username-link {
            color: inherit;
            /* Inherit the color from the parent */
            text-decoration: none;
            /* Remove the underline */
        }

        .username-link:hover {
            color: inherit;
            /* Keep the color the same on hover */
            text-decoration: none;
            /* Ensure the underline is not added on hover */
        }
    </style>

</head>

<body class="{{ session('dark_mode') === 'true' ? 'dark-mode' : '' }}">
    <nav class="navbar navbar-expand-lg {{ session('dark_mode') === 'true' ? 'navbar-dark bg-dark' : 'navbar-light bg-light border-primary' }}"
        id="navbar">
        <div class="container-fluid">
            <a class="navbar-brand ms-3 app-title text-primary" href="{{ route('home') }}">Social Media App</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                            <button class="btn border-0" style="margin-top: 15%; margin-right:20px;" id="darkModeToggle">
                                <i class="fas {{ session('dark_mode') === 'true' ? 'fa-sun' : 'fa-moon' }}"></i>
                            </button>
                        </li>
                    @auth
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">
                                <img src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('images/default_profile_image.png') }}"
                                    alt="Profile" class="profile-img" loading="lazy">
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" style="color: red; margin-top:8px;"
                                    class="btn btn-link nav-link fw-semibold">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
    @if (session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true" data-delay="3500">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var successToast = $('#successToast');
            if (successToast.length) {
                successToast.fadeIn().delay(1500).fadeOut();
            }
            var darkModeToggle = document.getElementById('darkModeToggle');
            var body = document.body;
            var navbar = document.getElementById('navbar');
            var darkModeIcon = darkModeToggle.querySelector('i');

            function applyDarkMode(darkModeEnabled) {
                navbar.classList.add('border-bottom');
                if (darkModeEnabled) {
                    body.classList.add('dark-mode');
                    navbar.classList.add('navbar-dark');
                    navbar.classList.add('bg-dark');
                    navbar.classList.remove('border-primary');
                    darkModeIcon.classList.remove('fa-moon');
                    darkModeIcon.classList.add('fa-sun');
                } else {
                    body.classList.remove('dark-mode');
                    navbar.classList.remove('navbar-dark');
                    navbar.classList.remove('bg-dark');
                    navbar.classList.add('border-primary');
                    darkModeIcon.classList.remove('fa-sun');
                    darkModeIcon.classList.add('fa-moon');
                }
                $.ajax({
                    url: '{{ route('toggle-dark-mode') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        dark_mode: darkModeEnabled
                    }
                });
            }

            darkModeToggle.addEventListener('click', function() {
                var darkModeEnabled = !body.classList.contains('dark-mode');
                applyDarkMode(darkModeEnabled);
            });

            // Apply dark mode if previously enabled
            var darkModeEnabled = '{{ session('dark_mode') }}' === 'true';
            applyDarkMode(darkModeEnabled);
        });
    </script>
</body>

</html>
