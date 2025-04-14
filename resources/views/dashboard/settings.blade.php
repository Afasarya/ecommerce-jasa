<x-dashboard-layout>
    <x-slot name="header">Pengaturan Akun</x-slot>
    <x-slot name="title">Pengaturan</x-slot>
    
    <div class="space-y-8">
        <!-- Update Profile Information -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Perbarui informasi profil dan alamat email akun Anda.
                </p>
            </div>
            
            <form action="{{ route('dashboard.profile.update') }}" method="POST" class="p-6">
                @csrf
                @method('PATCH')
                
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Update Password -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Ubah Password</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.
                </p>
            </div>
            
            <form action="{{ route('dashboard.password.update') }}" method="POST" class="p-6">
                @csrf
                @method('PATCH')
                
                <div class="mb-6">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" id="current_password" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>