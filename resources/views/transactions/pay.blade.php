x-app-layout>
    <x-slot name="title">Pembayaran</x-slot>
    
    <!-- Breadcrumbs -->
    <section class="bg-gray-50 py-4 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">
                            <i class="fas fa-home"></i>
                            <span class="sr-only">Home</span>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                        <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-primary-600">Keranjang</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                        <a href="{{ route('checkout') }}" class="text-gray-500 hover:text-primary-600">Checkout</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                        <span class="text-gray-700" aria-current="page">Pembayaran</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>
    
    <!-- Payment Content -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran</h1>
                <p class="text-gray-600">Nomor Pesanan: {{ $order->order_number }}</p>
            </div>
            
            <div class="max-w-lg mx-auto">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mb-4">
                                <i class="fas fa-credit-card text-2xl"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-1">Total Pembayaran</h2>
                            <p class="text-3xl font-bold text-primary-600 mb-4">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500 mb-4">
                                Silakan pilih metode pembayaran yang Anda inginkan untuk menyelesaikan transaksi.
                            </p>
                        </div>
                        
                        <div id="payment-methods" class="mt-6 grid grid-cols-3 gap-2 mb-4">
                            <div class="bg-white border border-gray-200 rounded p-2 flex items-center justify-center">
                                <img src="https://api.midtrans.com/v2/assets/images/payment-providers/bca_va.png" alt="BCA" class="h-6">
                            </div>
                            <div class="bg-white border border-gray-200 rounded p-2 flex items-center justify-center">
                                <img src="https://api.midtrans.com/v2/assets/images/payment-providers/mandiri_va.png" alt="Mandiri" class="h-6">
                            </div>
                            <div class="bg-white border border-gray-200 rounded p-2 flex items-center justify-center">
                                <img src="https://api.midtrans.com/v2/assets/images/payment-providers/bni_va.png" alt="BNI" class="h-6">
                            </div>
                            <div class="bg-white border border-gray-200 rounded p-2 flex items-center justify-center">
                                <img src="https://api.midtrans.com/v2/assets/images/payment-providers/bri_va.png" alt="BRI" class="h-6">
                            </div>
                            <div class="bg-white border border-gray-200 rounded p-2 flex items-center justify-center">
                                <img src="https://api.midtrans.com/v2/assets/images/payment-providers/gopay.png" alt="GoPay" class="h-6">
                            </div>
                            <div class="bg-white border border-gray-200 rounded p-2 flex items-center justify-center">
                                <img src="https://api.midtrans.com/v2/assets/images/payment-providers/shopeepay.png" alt="ShopeePay" class="h-6">
                            </div>
                        </div>
                        
                        <div id="payment-options">
                            <button id="pay-button" class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Pilih Metode Pembayaran
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-gray-50">
                        <h3 class="font-medium text-gray-900 mb-3">Detail Pesanan</h3>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Transaksi</span>
                                <span class="text-gray-900 font-medium">{{ $transaction->transaction_id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Waktu Pesanan</span>
                                <span class="text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu Pembayaran
                                </span>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('orders.show', $order->order_number) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali ke detail pesanan
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-6 text-sm text-gray-500">
                    <p>Butuh bantuan? <a href="{{ route('contact') }}" class="text-primary-600 hover:text-primary-700">Hubungi tim dukungan kami</a></p>
                </div>
            </div>
        </div>
    </section>
    
    @push('scripts')
    <!-- Midtrans JS SDK -->
    <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" 
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payButton = document.getElementById('pay-button');
            const snapToken = "{{ $snapToken }}";
            
            payButton.addEventListener('click', function() {
                // Show loading state
                payButton.disabled = true;
                payButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memuat metode pembayaran...';
                
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        payButton.innerHTML = '<i class="fas fa-check mr-2"></i> Pembayaran Berhasil';
                        
                        // Redirect with payment data
                        window.location.href = "{{ route('transaction.finish', $transaction->id) }}?" + new URLSearchParams(result);
                    },
                    onPending: function(result) {
                        payButton.innerHTML = '<i class="fas fa-clock mr-2"></i> Pembayaran Tertunda';
                        
                        // Redirect with payment data
                        window.location.href = "{{ route('transaction.finish', $transaction->id) }}?" + new URLSearchParams(result);
                    },
                    onError: function(result) {
                        payButton.disabled = false;
                        payButton.innerHTML = 'Pilih Metode Pembayaran';
                        
                        // Redirect with payment data
                        window.location.href = "{{ route('transaction.finish', $transaction->id) }}?" + new URLSearchParams(result);
                    },
                    onClose: function() {
                        // User closed the popup without finishing the payment
                        payButton.disabled = false;
                        payButton.innerHTML = 'Pilih Metode Pembayaran';
                        
                        console.log('Customer closed the payment window');
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>