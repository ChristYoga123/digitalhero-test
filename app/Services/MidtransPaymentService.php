<?php

namespace App\Services;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Booking;
use App\Models\Service;
use Midtrans\Transaction;
use Midtrans\Notification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\Booking\StatusEnum;
use Illuminate\Support\Facades\DB;
use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResponseFormatterController;

class MidtransPaymentService implements PaymentInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    private const STATUS_MAPPING = [
        'capture' => [
            'challenge' => StatusEnum::MENUNGGU,
            'accept' => StatusEnum::SUKSES,
        ],
        'cancel' => StatusEnum::BATAL,
        'deny' => StatusEnum::BATAL,
        'settlement' => StatusEnum::SUKSES,
        'pending' => StatusEnum::MENUNGGU,
        'expire' => StatusEnum::BATAL,
    ];

    public function pay(Booking $transaksi): string
    {
        DB::beginTransaction();
        try
        {
            $itemDetails = [
                'id' => $transaksi->order_id,
                'price' => $transaksi->total_harga,
                'quantity' => 1,
                'name' => "Pembayaran untuk transaksi {$transaksi->order_id}",
            ];
    
            $customerDetails = [
                'first_name' => $transaksi->user->name,
                'email' => $transaksi->user->email,
            ];
    
            $midtransParam = [
                'transaction_details' => [
                    'order_id' => $transaksi->order_id,
                    'gross_amount' => $transaksi->total_harga,
                ],
                'item_details' => [$itemDetails],
                'customer_details' => $customerDetails,
            ];

            DB::commit();
    
            return Snap::getSnapToken($midtransParam);
        }catch(Exception $e)
        {
            Log::error('Midtrans payment error: ' . $e->getMessage());
            return false;
        }
    }

    public function midtransCallback(Request $request)
    {
        DB::beginTransaction();
        try {
            $notif = $request->method() == 'POST' 
                ? new Notification() 
                : Transaction::status($request->order_id);

            $checkout = Booking::whereOrderId($notif->order_id)->firstOrFail();
            
            $status = self::STATUS_MAPPING[$notif->transaction_status] ?? 'failed';
            if ($notif->transaction_status === 'capture' || $notif->transaction_status === 'cancel') {
                $status = self::STATUS_MAPPING[$notif->transaction_status][$notif->fraud_status] ?? 'failed';
            }

            $checkout->status = $status;
            if ($checkout->status === StatusEnum::SUKSES) {
                $checkout->is_aktif = true;
                $checkout->service->decrement('slot');
            }
            $checkout->save();

            DB::commit();
            return ResponseFormatterController::success([
                'status' => $status,
            ], 'Midtrans Callback success');
            
        } catch(Exception $e) {
            Log::error('Midtrans callback error: ' . $e->getMessage());
            DB::rollBack();
            return ResponseFormatterController::error(message: 'Midtrans Callback gagal', code: 500);
        }
    }
}
