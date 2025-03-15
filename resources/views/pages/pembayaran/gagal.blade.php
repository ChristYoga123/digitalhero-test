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

        .failed-icon {
            display: inline-block;
            animation: shake 0.5s ease-in-out;
        }

        .payment-status-box h2 {
            font-size: 32px;
            margin-bottom: 15px;
            color: #F44336;
            font-weight: 700;
        }

        .status-message {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .error-details {
            margin-bottom: 30px;
        }

        .error-box {
            background: rgba(244, 67, 54, 0.05);
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #F44336;
            text-align: left;
        }

        .error-box h4 {
            color: #F44336;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .error-code {
            margin-top: 10px;
            font-size: 14px;
            color: #888;
        }

        .help-section {
            margin: 30px 0;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            text-align: left;
        }

        .help-section h4 {
            margin-bottom: 15px;
            color: #333;
            font-weight: 600;
        }

        .contact-info {
            display: flex;
            flex-wrap: wrap;
            margin-top: 15px;
            gap: 20px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact-item i {
            color: #555;
        }

        .action-buttons {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-style-three {
            background: transparent;
            border: 1px solid #333;
            color: #333;
        }

        .btn-style-three:hover {
            background: #333;
            color: white;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-10px);
            }

            40%,
            80% {
                transform: translateX(10px);
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

            .contact-info {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
@endpush
@section('content')
    <section class="payment-status-section" style="margin: 100px 0 0 0">
        <div class="auto-container">
            <div class="payment-status-box failed-box">
                <div class="icon-box">
                    <div class="failed-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100" height="100">
                            <circle cx="12" cy="12" r="11" fill="#F44336" stroke="none" />
                            <path
                                d="M16.192 6.344L11.949 10.586L7.707 6.344L6.293 7.758L10.535 12L6.293 16.242L7.707 17.656L11.949 13.414L16.192 17.656L17.606 16.242L13.364 12L17.606 7.758L16.192 6.344Z"
                                fill="#ffffff" />
                        </svg>
                    </div>
                </div>
                <h2>Pembayaran Gagal</h2>
                <p class="status-message">Maaf, transaksi Anda tidak dapat diproses saat ini. Silakan periksa detail
                    pembayaran dan coba lagi.</p>

                <div class="action-buttons">
                    <a href="{{ url()->previous() }}" class="theme-btn btn-style-one">
                        <span class="btn-title">Coba Lagi</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
