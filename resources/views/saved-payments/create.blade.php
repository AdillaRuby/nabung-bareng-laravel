@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Tambah Nabung</h1>
                <p class="text-gray-600">Sudah bayar langsung atau via QRIS</p>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <form action="{{ route('saved-payments.store') }}" method="POST" class="space-y-6">
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
                        Jumlah Pembayaran
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
                              placeholder="Tambahkan catatan untuk pembayaran ini..."></textarea>
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
                        Simpan Nabung
                    </button>
                </div>
            </form>
        </div>

        <!-- QRIS Modal Button -->
        <div class="mt-8 text-center">
            <button id="showQrisModal" type="button"
                    class="inline-flex items-center px-6 py-3 border border-orange-300 text-sm font-medium rounded-xl text-orange-700 bg-orange-50 hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M12 15h4.01M12 21h4.01M12 18h4.01M12 9h4.01M12 6h4.01M12 3h4.01"></path>
                </svg>
                Bayar via QRIS
            </button>
        </div>

        <!-- QRIS Modal -->
        <div id="qrisModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-2xl bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 mb-4">
                        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M12 15h4.01M12 21h4.01M12 18h4.01M12 9h4.01M12 6h4.01M12 3h4.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Scan QRIS</h3>
                    <p class="text-sm text-gray-600 mb-6">Scan kode QR berikut untuk melakukan pembayaran</p>

                    <div class="mb-6">
                        <img src="{{ asset('qris/qris.png') }}" alt="QRIS Code" class="mx-auto max-w-full h-auto rounded-lg shadow-md">
                    </div>

                    <div class="flex items-center justify-between">
                        <button id="closeQrisModal" type="button"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200">
                            Tutup
                        </button>
                        <button id="confirmPayment" type="button"
                                class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200">
                            Sudah Bayar
                        </button>
                    </div>
                </div>
            </div>
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
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Pembayaran Sudah Dikonfirmasi</h3>
                    <p class="text-sm text-gray-700">Pastikan pembayaran ini sudah benar-benar diterima sebelum menambahkannya ke sistem.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const showQrisModal = document.getElementById('showQrisModal');
    const qrisModal = document.getElementById('qrisModal');
    const closeQrisModal = document.getElementById('closeQrisModal');
    const confirmPayment = document.getElementById('confirmPayment');

    showQrisModal.addEventListener('click', function() {
        qrisModal.classList.remove('hidden');
    });

    closeQrisModal.addEventListener('click', function() {
        qrisModal.classList.add('hidden');
    });

    confirmPayment.addEventListener('click', function() {
        qrisModal.classList.add('hidden');
        // Scroll to form
        document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
    });

    // Close modal when clicking outside
    qrisModal.addEventListener('click', function(e) {
        if (e.target === qrisModal) {
            qrisModal.classList.add('hidden');
        }
    });
});
</script>


