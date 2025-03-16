@extends('layouts.front')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <style>
        .fc-day-today {
            background-color: rgba(255, 220, 40, 0.15) !important;
        }

        .fc-day-selected {
            background-color: rgba(0, 120, 255, 0.3) !important;
        }

        .booking-section {
            padding: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-top: 40px;
        }

        .calendar-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .booking-form {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .price-card {
            background: linear-gradient(145deg, #f8f9fa, #e9ecef);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #dee2e6;
        }

        .price-item:last-child {
            border-bottom: none;
        }

        .price-total {
            font-size: 1.25rem;
            font-weight: bold;
            color: #007bff;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 105, 217, 0.4);
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #495057;
        }

        #tanggal_booking {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        /* Make calendar cells more tappable on mobile */
        .fc .fc-daygrid-day-frame {
            min-height: 45px;
        }
    </style>
@endpush
@section('content')
    <!--Page Title-->
    @Title([
        'title' => $service->nama,
        'breadcrumbs' => [['title' => 'Services', 'url' => route('service.index')], ['title' => $service->nama]],
    ])
    <!--End Page Banner-->

    <!--Games Section-->
    <section class="games-section games-page-section">
        <div class="auto-container">
            <!--Game Details-->
            <div class="game-details">
                <div class="inner">
                    <div class="image-box">
                        <figure class="image"><a href="{{ asset('assets/images/resource/game-detail.jpg') }}"
                                class="lightbox-image"><img src="{{ $service->getFirstMediaUrl('service-image') }}"
                                    alt="{{ $service->nama }}"></a></figure>
                    </div>
                    <div class="lower-content">
                        <div class="title-box clearfix">
                            <div class="title">
                                <h2>{{ $service->nama }}</h2>
                                <div class="post-info">
                                    <ul class="clearfix">
                                        <li>Tersisa {{ $service->slot }} Slot</li>
                                        <li><span
                                                class="badge {{ $service->slot > 0 ? 'badge-success' : 'badge-danger' }}">{{ $service->slot > 0 ? 'Tersedia' : 'Tidak Tersedia' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="link-box"><a href="#" class="link-btn"> <span
                                        class="btn-title">{{ $service->nama }}</span></a></div>
                        </div>
                        <div class="text">
                            <p>{!! $service->deskripsi !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Section -->
            <div class="booking-section mt-5">
                <div class="section-title mb-4">
                    <h3>Pemesanan Layanan</h3>
                    <p class="text-muted">Pilih tanggal dan jumlah sesi untuk melakukan pemesanan</p>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="calendar-container">
                            <div id="booking-calendar"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="booking-form">
                            <form id="bookingForm">
                                <input type="hidden" id="selected_date" name="selected_date">
                                <input type="hidden" id="is_weekend" name="is_weekend" value="0">

                                <div class="form-group mb-4">
                                    <label class="form-label" for="tanggal_booking">Tanggal Booking</label>
                                    <input type="text" class="form-control" id="tanggal_booking"
                                        placeholder="Pilih tanggal pada kalender" readonly>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label" for="jumlah_sesi">Jumlah Sesi</label>
                                    <input type="number" class="form-control" id="jumlah_sesi" name="jumlah_sesi"
                                        min="1" value="1">
                                    <small class="text-muted">Minimum 1 sesi</small>
                                </div>

                                <div class="price-card mt-4">
                                    <h5 class="mb-3">Rincian Harga</h5>
                                    <div class="price-item">
                                        <span>Harga Layanan ({{ $service->nama }})</span>
                                        <span>Rp {{ number_format($service->harga_per_sesi, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="price-item">
                                        <span>Jumlah Sesi</span>
                                        <span id="display_sesi">1</span>
                                    </div>
                                    <div class="price-item">
                                        <span>Weekend Charge</span>
                                        <span id="weekend_charge">Rp 0</span>
                                    </div>
                                    <div class="price-total">
                                        <span>Total Harga</span>
                                        <span id="total_harga">Rp {{ number_format($service->harga, 0, ',', '.') }}</span>
                                        <input type="hidden" id="total_harga_value" name="total_harga_value"
                                            value="{{ $service->harga }}">
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="button" id="bayarBtn" class="btn btn-primary btn-block"
                                        onclick="beli()">
                                        <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.10.1/main.min.js"></script>
    <script
        src="{{ env('APP_ENV') === 'local' ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        // Initialize FullCalendar
        function initializeCalendar() {
            const calendarEl = document.getElementById('booking-calendar');
            if (!calendarEl) return;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                timeZone: 'Asia/Jakarta', // Set Jakarta timezone explicitly
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                selectable: true,
                selectConstraint: {
                    start: new Date().toISOString().split('T')[0], // Today and future
                },
                // Add these properties for better mobile support
                selectLongPressDelay: 100, // Make long press more responsive on mobile
                eventLongPressDelay: 100,
                longPressDelay: 100,
                selectMinDistance: 5, // Prevent accidental touches from being interpreted as drags
                // Enable interaction on touch devices
                themeSystem: 'bootstrap',
                height: 'auto',
                contentHeight: 'auto',
                select: function(info) {
                    // Remove previous selection styling
                    document.querySelectorAll('.fc-day-selected').forEach(el => {
                        el.classList.remove('fc-day-selected');
                    });

                    // Add selected class
                    document.querySelector(`.fc-day[data-date="${info.startStr}"]`).classList.add(
                        'fc-day-selected');

                    // Update form with selected date
                    const selectedDate = new Date(info.startStr);
                    const formattedDate = formatDate(selectedDate);
                    document.getElementById('tanggal_booking').value = formattedDate;
                    document.getElementById('selected_date').value = info.startStr;

                    // Check if weekend
                    const day = selectedDate.getDay();
                    const isWeekend = (day === 0 || day === 6); // 0 is Sunday, 6 is Saturday
                    document.getElementById('is_weekend').value = isWeekend ? 1 : 0;

                    // Update weekend charge and calculate total
                    calculateTotal();

                    // Enable pay button if form is valid
                    validateBookingForm();
                },
                validRange: function() {
                    // Create today's date in Jakarta time zone
                    const today = new Date();
                    const jakartaOffset = 7 * 60; // Jakarta is UTC+7
                    const localOffset = today.getTimezoneOffset();
                    const jakartaTime = new Date(today.getTime() + (jakartaOffset + localOffset) * 60000);

                    // Format as YYYY-MM-DD for comparison
                    const jakartaDate = jakartaTime.toISOString().split('T')[0];

                    return {
                        start: jakartaDate
                    };
                }
            });

            calendar.render();
        }

        // The rest of your functions remain unchanged
        function formatDate(date) {
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return date.toLocaleDateString('id-ID', options);
        }

        function calculateTotal() {
            const basePrice = {{ $service->harga_per_sesi }};
            const sesi = parseInt(document.getElementById('jumlah_sesi').value) || 1;
            const isWeekend = parseInt(document.getElementById('is_weekend').value) === 1;

            let total = basePrice * sesi;
            let weekendCharge = 0;

            if (isWeekend) {
                weekendCharge = 50000;
                total += weekendCharge;
                document.getElementById('weekend_charge').textContent = 'Rp ' + weekendCharge.toLocaleString('id-ID');
            } else {
                document.getElementById('weekend_charge').textContent = 'Rp 0';
            }

            document.getElementById('total_harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('total_harga_value').value = total;
        }

        function validateBookingForm() {
            const selectedDate = document.getElementById('selected_date').value;
            const sesi = parseInt(document.getElementById('jumlah_sesi').value) || 0;

            const isValid = selectedDate !== '' && sesi > 0;

            return isValid;
        }

        function beli() {
            @guest
            window.location.href = '{{ route('filament.user.auth.login') }}';
            return;
        @endguest
        if (validateBookingForm() === false) {
            toastr.error('Mohon isi tanggal dan jumlah sesi terlebih dahulu');
            return;
        }

        $.ajax({
            url: `{{ route('service.booking', $service->slug) }}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                tanggal_booking: document.getElementById('selected_date').value,
                jumlah_sesi: document.getElementById('jumlah_sesi').value,
                total_harga: document.getElementById('total_harga_value').value
            },
            beforeSend: function() {
                $('#bayarBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin mr-2"></i> Loading...');
            },
            success: function(response) {
                $('#bayarBtn').prop('disabled', false).html(
                    '<i class="fas fa-credit-card mr-2"></i> Bayar Sekarang');
                snap.pay(response.data.snap_token, {
                    onSuccess: function(result) {
                        // toastr.success('Pembayaran berhasil!');
                        window.location.href = '{{ route('pembayaran.sukses') }}';
                    },
                    onPending: function(result) {
                        // toastr.info('Pembayaran sedang diproses');
                        window.location.href = '{{ route('pembayaran.gagal') }}';
                    },
                    onError: function(result) {
                        // toastr.error('Pembayaran gagal!');
                        window.location.href = '{{ route('pembayaran.gagal') }}';
                    }
                });
            },
            error: function(xhr) {
                $('#bayarBtn').prop('disabled', false).html(
                    '<i class="fas fa-credit-card mr-2"></i> Bayar Sekarang');
                toastr.error(xhr.responseJSON.message);
            }
        })
        }

        // Setup event listeners
        function setupEventListeners() {
            // Event listener for jumlah_sesi input
            document.getElementById('jumlah_sesi').addEventListener('input', function() {
                document.getElementById('display_sesi').textContent = this.value;
                calculateTotal();
                validateBookingForm();
            });

            // Handle input validation for jumlah_sesi
            document.getElementById('jumlah_sesi').addEventListener('change', function() {
                const value = parseInt(this.value) || 0;
                if (value < 1) {
                    this.value = 1;
                    document.getElementById('display_sesi').textContent = '1';
                } else {
                    document.getElementById('display_sesi').textContent = value.toString();
                }
                calculateTotal();
            });
        }

        // Initialize everything when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializeCalendar();
            setupEventListeners();
        });
    </script>
@endpush
