<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex bg-gray-100">

    <!-- LEFT -->
    <div
        class="hidden lg:flex w-1/2 items-center justify-center relative
        bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-500 text-white">

        <div class="text-center px-10">
            <h1 class="text-5xl font-bold mb-4">Personal Finance</h1>
            <p class="text-lg opacity-90">
                Mulai perjalanan keuanganmu sekarang.
            </p>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="w-full lg:w-1/2 flex items-center justify-center">

        <div class="w-full max-w-md px-6">

            <h2 class="text-3xl font-bold mb-2 text-gray-800">
                Register
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Buat akun untuk mulai mengelola keuangan
            </p>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="mb-4 text-red-500 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- NAME -->
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Name</label>
                    <input type="text" name="name" required
                        class="w-full bg-transparent border-b border-gray-300 px-1 py-2 mt-1
                        focus:outline-none focus:border-indigo-500">
                </div>

                <!-- EMAIL -->
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" required
                        class="w-full bg-transparent border-b border-gray-300 px-1 py-2 mt-1
                        focus:outline-none focus:border-indigo-500">
                </div>

                <!-- PASSWORD -->
                <div class="mb-4">
                    <label class="text-sm text-gray-600">Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-transparent border-b border-gray-300 px-1 py-2 mt-1
                        focus:outline-none focus:border-indigo-500">
                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mb-6">
                    <label class="text-sm text-gray-600">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full bg-transparent border-b border-gray-300 px-1 py-2 mt-1
                        focus:outline-none focus:border-indigo-500">
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-md
                    hover:bg-indigo-700 transition">
                    Sign Up
                </button>
            </form>

            <!-- LINK -->
            <p class="text-sm text-center mt-6 text-gray-500">
                Already have an account?
                <a href="{{ route('login') }}" class="text-indigo-600 font-semibold">
                    Sign In
                </a>
            </p>

        </div>
    </div>

</body>

</html>
