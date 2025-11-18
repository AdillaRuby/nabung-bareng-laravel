@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-gray-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Tambah Penarikan</h1>
                <p class="text-gray-600">Masukkan detail penarikan yang akan dilakukan</p>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <form action="{{ route('withdraws.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Transaction Date Input -->
                <div>
                    <label for="transaction_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Transaksi
                    </label>
                    <input type="date" name="transaction_date" id="transaction_date"
                           class="block w-full px-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200 bg-white text-gray-900"
                           value="{{ date('Y-m-d') }}">
                    @error('transaction_date')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Amount Input -->
                <div>
                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                        Jumlah Penarikan
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="amount" id="amount" step="0.01" min="0.01"
                               class="block w-full pl-12 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200 bg-white text-gray-900 placeholder-gray-500"
                               placeholder="0.00" required>
                    </div>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Note Input -->
                <div>
                    <label for="note" class="block text-sm font-semibold text-gray-700 mb-2">
                        Catatan <span class="text-gray-500 font-normal">(Opsional)</span>
                    </label>
                    <textarea name="note" id="note" rows="4"
                              class="block w-full px-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200 bg-white text-gray-900 placeholder-gray-500 resize-none"
                              placeholder="Tambahkan catatan untuk penarikan ini..."></textarea>
                    @error('note')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <a href="{{ route('dashboard') }}"
                       class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Penarikan
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-8 bg-gray-50 rounded-2xl p-6 border border-gray-200">
            <div class="flex items-start">
                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                    <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Penarikan Dana</h3>
                    <p class="text-sm text-gray-700">Pastikan jumlah penarikan sesuai dengan saldo yang tersedia dan kebutuhan Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
