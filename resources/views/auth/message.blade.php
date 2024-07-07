<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->

    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/favicon.png" />

    <!-- Custom CSS for alerts -->
    <style>
        .custom-alert {
            animation: fadeInUp 0.5s ease-in-out;
            border-radius: 5px;
        }

        .custom-alert .alert-icon {
            margin-right: 10px;
        }

        .custom-alert .alert-text {
            font-weight: 500;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <!-- Pesan Alert -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
        <span class="alert-icon"><i class="mdi mdi-check-circle-outline"></i></span>
        <span class="alert-text">{{ session('success') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
        <span class="alert-icon"><i class="mdi mdi-alert-outline"></i></span>
        <span class="alert-text">{{ session('error') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
        <span class="alert-icon"><i class="mdi mdi-alert-outline"></i></span>
        <span class="alert-text">Please fix the following errors:</span>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Your HTML content here -->

    <!-- JavaScript for auto-dismissing alerts -->
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    </script>
</body>
</html>
