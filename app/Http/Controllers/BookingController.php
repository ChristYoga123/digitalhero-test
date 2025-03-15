<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\Booking\StatusEnum;
use Illuminate\Support\Facades\DB;
use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct(
        private PaymentInterface $paymentService
    )
    {}

    private function deleteUnpaidBooking(Service $service)
    {
        Booking::where('service_id', $service->id)
            ->whereUserId(Auth::id())
            ->whereNot('status', StatusEnum::SUKSES)
            ->whereIsAktif(false)
            ->delete();
    }

    public function beli(Request $request, Service $service)
    {
        $request->validate([
            'tanggal_booking' => 'required|date',
            'jumlah_sesi' => 'required|integer|min:1',
        ], [
            'tanggal_booking.required' => 'Tanggal booking tidak boleh kosong',
            'tanggal_booking.date' => 'Tanggal booking harus berupa tanggal',
            'jumlah_sesi.required' => 'Jumlah sesi tidak boleh kosong',
            'jumlah_sesi.integer' => 'Jumlah sesi harus berupa angka',
            'jumlah_sesi.min' => 'Jumlah sesi minimal 1',
        ]);

        // hapus booking yang belum dibayar
        $this->deleteUnpaidBooking($service);

        // cek apakah user sudah pernah booking service ini
        if($service->isBookedByCurrentUser($request->tanggal_booking) === true) {
            return ResponseFormatterController::error(message: 'Anda sudah pernah melakukan booking untuk rental ini');
        }

        // cek apakah slot masih tersedia
        if(!$service->isSlotAvailable()) {
            return ResponseFormatterController::error(message: 'Slot sudah penuh');
        }

        DB::beginTransaction();
        try
        {
            $booking = Booking::create([
                'order_id' => 'DH-' . Str::random(6),
                'user_id' => Auth::id(),
                'service_id' => $service->id,
                'tanggal_booking' => $request->tanggal_booking,
                'jumlah_sesi' => $request->jumlah_sesi,
                'total_harga' => $request->jumlah_sesi * $service->harga_per_sesi + (Carbon::parse($request->tanggal_booking)->isWeekend() ? 50000 : 0),
            ]);

            $snapToken = $this->paymentService->pay($booking);

            if(!$snapToken)
            {
                DB::rollBack();
                return ResponseFormatterController::error(message: 'Gagal generate snap token', code: 500);
            }

            DB::commit();
            return ResponseFormatterController::success([
                'snap_token' => $snapToken,
            ], 'Berhasil generate snap token');
        }catch(Exception $e)
        {
            Log::error($e->getMessage());
            DB::rollBack();
            return ResponseFormatterController::error(message: 'Gagal melakukan booking', code: 500);
        }
    }

    public function pembayaranSukses()
    {
        return view('pages.pembayaran.sukses', [
            'title' => 'Pembayaran Sukses',
        ]);
    }

    public function pembayaranGagal()
    {
        return view('pages.pembayaran.gagal', [
            'title' => 'Pembayaran Gagal',
        ]);
    }
}
