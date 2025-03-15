@extends('layouts.front')
@push('styles')
    <style>
        .payment-status-section {
            padding: 80px 0;
        }

        .payment-status-box {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .payment-status-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .payment-status-box .icon-box {
            margin-bottom: 25px;
        }

        .success-icon {
            display: inline-block;
            animation: scaleUp 0.5s ease-in-out;
        }

        .payment-status-box h2 {
            font-size: 32px;
            margin-bottom: 15px;
            color: #4CAF50;
            font-weight: 700;
        }

        .status-message {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .payment-details {
            background: rgba(76, 175, 80, 0.05);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: left;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-item .label {
            font-weight: 600;
            color: #333;
        }

        .detail-item .value {
            color: #666;
        }

        .action-buttons {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        @keyframes scaleUp {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            80% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @media (max-width: 767px) {
            .payment-status-box {
                padding: 30px 20px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .theme-btn {
                margin-bottom: 10px;
            }
        }
    </style>
@endpush
@section('content')
    <section class="payment-status-section" style="margin: 100px 0 0 0">
        <div class="auto-container">
            <div class="payment-status-box success-box">
                <div class="icon-box">
                    <div class="success-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100" height="100">
                            <circle cx="12" cy="12" r="11" fill="#4CAF50" stroke="none" />
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" fill="#ffffff" />
                        </svg>
                    </div>
                </div>
                <h2>Pembayaran Berhasil!</h2>
                <p class="status-message">Transaksi Anda telah berhasil diproses dan dikonfirmasi. Terima kasih telah
                    melakukan pembayaran.</p>

                <div class="action-buttons">
                    <a href="{{ route('filament.user.resources.bookings.index') }}" class="theme-btn btn-style-one">
                        <span class="btn-title">Lihat Pesanan Saya</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
