<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="hero min-h-screen"
        style="background-image:url(https://img.freepik.com/free-photo/isometric-view-3d-rendering-neon-city_23-2150900827.jpg?t=st=1718959893~exp=1718963493~hmac=cae85cc470ae7d6d1efcf8f5117c082d00660ef3ab5d4b0e3034fc096bbdc864&w=740)">
        <div class="hero-overlay"></div>
        <div class="hero-content text-center text-white">
            <div class="max-w-md">
                <h1 class="text-6xl font-bold">Smart Building</h1>
                <p class="py-4">Smart building adalah bangunan yang dilengkapi dengan teknologi canggih dan
                    sistem otomatisasi untuk mengelola berbagai aspek operasionalnya.</p>
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-default">Login</a>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
