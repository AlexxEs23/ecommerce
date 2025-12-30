<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
    }

    /**
     * Handle Midtrans webhook notification
     */
    public function handle(Request $request)
    {
        try {
            // Create notification object from Midtrans
            $notification = new Notification();

            // Get transaction details
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            $orderId = $notification->order_id;
            
            Log::info('Midtrans Notification Received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
            ]);

            // Extract pesanan ID from order_id (format: ORDER-{id}-{timestamp})
            $pesananId = $this->extractPesananId($orderId);
            
            if (!$pesananId) {
                Log::error('Invalid order_id format', ['order_id' => $orderId]);
                return response()->json(['status' => 'error', 'message' => 'Invalid order ID'], 400);
            }

            // Find pesanan
            $pesanan = Pesanan::find($pesananId);
            
            if (!$pesanan) {
                Log::error('Pesanan not found', ['pesanan_id' => $pesananId]);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // Handle different transaction statuses
            $newStatus = $this->determineOrderStatus($transactionStatus, $fraudStatus);
            
            if ($newStatus) {
                $this->updatePesananStatus($pesanan, $newStatus, $transactionStatus);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Extract pesanan ID from Midtrans order_id
     */
    private function extractPesananId($orderId)
    {
        // Format: ORDER-{id}-{timestamp}
        $parts = explode('-', $orderId);
        
        if (count($parts) >= 2 && $parts[0] === 'ORDER') {
            return (int) $parts[1];
        }
        
        return null;
    }

    /**
     * Determine order status based on Midtrans transaction status
     */
    private function determineOrderStatus($transactionStatus, $fraudStatus)
    {
        switch ($transactionStatus) {
            case 'capture':
                // For credit card, need to check fraud status
                return ($fraudStatus === 'accept') ? 'dibayar' : 'pending_payment';
                
            case 'settlement':
                // Payment successful
                return 'dibayar';
                
            case 'pending':
                // Payment pending
                return 'pending_payment';
                
            case 'deny':
            case 'expire':
            case 'cancel':
                // Payment failed/cancelled
                return 'dibatalkan';
                
            default:
                Log::warning('Unknown transaction status', ['status' => $transactionStatus]);
                return null;
        }
    }

    /**
     * Update pesanan status and handle stock
     */
    private function updatePesananStatus($pesanan, $newStatus, $transactionStatus)
    {
        $oldStatus = $pesanan->status;
        
        // Only update if status changed
        if ($oldStatus === $newStatus) {
            Log::info('Status unchanged', [
                'pesanan_id' => $pesanan->id,
                'status' => $newStatus
            ]);
            return;
        }

        // Handle stock reduction when payment is successful
        if ($newStatus === 'dibayar' && $oldStatus === 'pending_payment') {
            // Reduce stock
            $produk = $pesanan->produk;
            if ($produk && $produk->stok >= $pesanan->jumlah) {
                $produk->decrement('stok', $pesanan->jumlah);
                
                Log::info('Stock reduced', [
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $produk->id,
                    'quantity' => $pesanan->jumlah,
                    'remaining_stock' => $produk->stok
                ]);
            } else {
                Log::warning('Insufficient stock', [
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $produk->id ?? null,
                    'required' => $pesanan->jumlah,
                    'available' => $produk->stok ?? 0
                ]);
            }
        }

        // Handle stock restoration when payment is cancelled/expired
        if ($newStatus === 'dibatalkan' && $oldStatus === 'pending_payment') {
            // No need to restore stock as it was never reduced
            Log::info('Payment cancelled, no stock to restore', [
                'pesanan_id' => $pesanan->id
            ]);
        }

        // Update pesanan status
        $pesanan->update(['status' => $newStatus]);
        
        Log::info('Pesanan status updated', [
            'pesanan_id' => $pesanan->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'transaction_status' => $transactionStatus
        ]);
    }
}
