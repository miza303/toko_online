<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Toko Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-10">
    <div class="max-w-md w-full bg-white rounded-xl shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">🛒 Toko Online</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar sebagai pembeli</p>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No. HP (opsional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-md font-medium hover:bg-blue-700">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Masuk</a>
        </p>
    </div>
</body>
</html>
