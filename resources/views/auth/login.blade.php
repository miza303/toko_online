<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Toko Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">🛒 Toko Online</h1>
            <p class="text-gray-500 text-sm mt-1">Masuk ke akun kamu</p>
        </div>

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md text-sm">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-brand-500 focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-blue-500">
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember"> Ingat saya
            </label>
            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-md font-medium hover:bg-blue-700">
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">Daftar sebagai pembeli</a>
        </p>

        <div class="mt-6 pt-4 border-t text-xs text-gray-400">
            <p><strong>Demo akun:</strong></p>
            <p>Penjual: admin@toko.test / password</p>
            <p>Pembeli: customer@toko.test / password</p>
        </div>
    </div>
</body>
</html>
