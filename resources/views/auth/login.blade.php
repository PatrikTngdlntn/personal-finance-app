<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex bg-gray-100">

    <!-- LEFT SIDE -->
    <div
        class="hidden lg:flex w-1/2 items-center justify-center relative
        bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-500 text-white">

        <div class="text-center px-10">
            <h1 class="text-5xl font-bold mb-4">Personal Finance</h1>
            <p class="text-lg opacity-90 mb-8">
                Kelola keuanganmu dengan lebih mudah, cepat, dan terstruktur.
            </p>

            <!-- ILUSTRASI (OPSIONAL) -->
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="w-40 mx-auto opacity-90"
                alt="finance">
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-gray-100">

        <div class="w-full max-w-md px-6">

            <h2 class="text-3xl font-bold mb-2 text-gray-800">
                Log In
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Enter your email and password to login
            </p>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="mb-4 text-red-500 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- EMAIL -->
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" required
                        class="w-full bg-transparent border-b border-gray-300 px-1 py-2 mt-1
                    focus:outline-none focus:border-indigo-500">
                </div>

                <!-- PASSWORD -->
                <div class="mb-6">
                    <label class="text-sm text-gray-600">Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-transparent border-b border-gray-300 px-1 py-2 mt-1
                    focus:outline-none focus:border-indigo-500">
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-md
                hover:bg-indigo-700 transition">
                    Sign In
                </button>
            </form>

            <!-- LINK -->
            <p class="text-sm text-center mt-6 text-gray-500">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 font-semibold">
                    Sign Up
                </a>
            </p>

        </div>
    </div>

</body>

</html>
