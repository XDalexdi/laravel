<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KIU Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">KIU Student Task Manager</a>
            
            @auth
            <div>
                <span class="text-white me-3">Hello, {{ Auth::user()->name }}!</span>
                
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Log Out</button>
                </form>
            </div>
            @endauth
        </div>
    </nav>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @yield('content') 
    </div>
</body>
</html>