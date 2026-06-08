<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    @vite('resources/css/app.css')

    <script defer src="https://unpkg.com/alpinejs"></script>
</head>

<body class="min-h-screen flex bg-gray-100">

    <!-- LEFT -->
    <div
        class="hidden lg:flex w-1/2 items-center justify-center relative
        bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-500 text-white">

        <div class="text-center px-10">
            <h1 class="text-5xl font-bold mb-4">
                Personal Finance
            </h1>

            <p class="text-lg opacity-90">
                Mulai perjalanan keuanganmu sekarang.
            </p>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="w-full lg:w-1/2 flex items-center justify-center py-10">

        <div class="w-full max-w-md px-6">

            <h2 class="text-3xl font-bold mb-2 text-gray-800">
                Register
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Buat akun untuk mulai mengelola keuangan
            </p>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200">
                    <ul class="text-red-500 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">

                @csrf

                <!-- AVATAR -->
                <div class="mb-6" x-data="{ imageUrl: null }">

                    <label class="block text-sm text-gray-600 mb-3">
                        Foto Profil (Opsional)
                    </label>

                    <div class="flex items-center gap-4">

                        <img :src="imageUrl || 'https://ui-avatars.com/api/?name=User'"
                            class="w-20 h-20 rounded-full border object-cover">

                        <input type="file" name="avatar" accept="image/*"
                            @change="
                                const file = $event.target.files[0];
                                if(file){
                                    imageUrl = URL.createObjectURL(file);
                                }
                            "
                            class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:bg-indigo-50
                            file:text-indigo-700
                            hover:file:bg-indigo-100">
                    </div>

                    @error('avatar')
                        <p class="text-red-500 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- NAME -->
                <div class="mb-4">

                    <label class="text-sm text-gray-600">
                        Name
                    </label>

                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full bg-transparent border-b border-gray-300
                        px-1 py-2 mt-1
                        focus:outline-none
                        focus:border-indigo-500">

                    @error('name')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- EMAIL -->
                <div class="mb-4">

                    <label class="text-sm text-gray-600">
                        Email
                    </label>

                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-transparent border-b border-gray-300
                        px-1 py-2 mt-1
                        focus:outline-none
                        focus:border-indigo-500">

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- PASSWORD -->
                <div class="mb-4" x-data="{ showPassword: false }">

                    <label class="text-sm text-gray-600">
                        Password
                    </label>

                    <div class="relative">

                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            class="w-full bg-transparent border-b border-gray-300
                            px-1 py-2 mt-1
                            focus:outline-none
                            focus:border-indigo-500">

                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-0 top-2 text-sm text-indigo-600">

                            <span x-show="!showPassword">
                                Show
                            </span>

                            <span x-show="showPassword">
                                Hide
                            </span>

                        </button>

                    </div>

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mb-6" x-data="{ showConfirmPassword: false }">

                    <label class="text-sm text-gray-600">
                        Confirm Password
                    </label>

                    <div class="relative">

                        <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required
                            class="w-full bg-transparent border-b border-gray-300
                            px-1 py-2 mt-1
                            focus:outline-none
                            focus:border-indigo-500">

                        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute right-0 top-2 text-sm text-indigo-600">

                            <span x-show="!showConfirmPassword">
                                Show
                            </span>

                            <span x-show="showConfirmPassword">
                                Hide
                            </span>

                        </button>

                    </div>

                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg
                    hover:bg-indigo-700 transition duration-300">

                    Sign Up

                </button>

            </form>

            <!-- LOGIN -->
            <p class="text-sm text-center mt-6 text-gray-500">

                Already have an account?

                <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">

                    Sign In

                </a>

            </p>

        </div>

    </div>

</body>

</html>
