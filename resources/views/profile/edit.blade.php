<x-app-layout :title="'Profil Saya'">
    <div class="max-w-2xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold text-gray-800 mb-4">Informasi Akun</h2>
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('address', $user->address) }}</textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md font-medium hover:bg-blue-700">Simpan</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="font-semibold text-gray-800 mb-4">Ubah Password</h2>
            <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <button type="submit" class="bg-gray-800 text-white px-5 py-2 rounded-md font-medium hover:bg-gray-900">Ubah Password</button>
            </form>
        </div>
    </div>
</x-app-layout>
