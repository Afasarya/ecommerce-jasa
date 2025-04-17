<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;
use Exception;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        $this->configureMidtrans();
    }
    
    /**
     * Set up Midtrans configuration
     */
    private function configureMidtrans()
    {
        try {
            $serverKey = config('midtrans.server_key');
            $clientKey = config('midtrans.client_key');
            
            // Basic Midtrans configuration
            Config::$serverKey = $serverKey;
            Config::$clientKey = $clientKey;
            Config::$isProduction = false; // Force sandbox mode for testing
            Config::$isSanitized = true;
            Config::$is3ds = true;
            
            // Improved curl options for better SSL handling
            Config::$curlOptions = [
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Basic ' . base64_encode($serverKey . ':')
                ],
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_SSL_VERIFYPEER => false,  // For debugging only
                CURLOPT_SSL_VERIFYHOST => 0       // For debugging only
            ];
            
            Log::debug('Midtrans configuration set up successfully', [
                'server_key_exists' => !empty($serverKey),
                'client_key_exists' => !empty($clientKey),
                'is_production' => false
            ]);
            
        } catch (Exception $e) {
            Log::error('Failed to configure Midtrans: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create Snap Token for payment - direct cURL implementation
     * 
     * @param array $params
     * @return string
     */
    public function createSnapToken(array $params): string
    {
        try {
            // Sanitize and validate parameters
            $this->sanitizeParams($params);
            
            // Log request details (excluding sensitive information)
            Log::debug('Creating Midtrans Snap token with parameters', [
                'transaction_id' => $params['transaction_details']['order_id'] ?? 'unknown',
                'amount' => $params['transaction_details']['gross_amount'] ?? 0,
                'item_count' => count($params['item_details'] ?? [])
            ]);
            
            // Directly make the API request using cURL for better control
            $url = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode(Config::$serverKey . ':')
            ]);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if (curl_errno($ch)) {
                $error = curl_error($ch);
                curl_close($ch);
                Log::error('Midtrans cURL error', ['error' => $error]);
                throw new Exception('cURL Error: ' . $error);
            }
            
            curl_close($ch);
            
            // Log response data for debugging
            Log::debug('Midtrans API response', [
                'http_code' => $httpCode, 
                'response' => $response
            ]);
            
            $responseData = json_decode($response, true);
            
            // Check for error response
            if ($httpCode >= 400) {
                $errorMessage = isset($responseData['error_messages']) 
                    ? implode(', ', $responseData['error_messages']) 
                    : 'Unknown error';
                    
                Log::error('Midtrans API error', [
                    'http_code' => $httpCode,
                    'message' => $errorMessage,
                    'response' => $responseData
                ]);
                
                throw new Exception('Midtrans API error: ' . $errorMessage);
            }
            
            // Verify response contains token
            if (!isset($responseData['token'])) {
                Log::error('Invalid Midtrans response - no token found', ['response' => $responseData]);
                throw new Exception('Invalid response from Midtrans: Token not found');
            }
            
            Log::info('Successfully obtained Midtrans snap token');
            return $responseData['token'];
            
        } catch (Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            throw new Exception('Error creating Midtrans Snap Token: ' . $e->getMessage());
        }
    }
    
    /**
     * Sanitize and validate parameters for Midtrans
     */
    private function sanitizeParams(array &$params): void
    {
        // Ensure transaction details exist and have required fields
        if (!isset($params['transaction_details'])) {
            $params['transaction_details'] = [];
        }
        
        if (!isset($params['transaction_details']['order_id'])) {
            $params['transaction_details']['order_id'] = 'ORDER-' . time() . rand(1000, 9999);
        }
        
        // Ensure gross_amount is an integer
        if (isset($params['transaction_details']['gross_amount'])) {
            $params['transaction_details']['gross_amount'] = (int)$params['transaction_details']['gross_amount'];
        }
        
        // Ensure all items have integer prices
        if (isset($params['item_details']) && is_array($params['item_details'])) {
            foreach ($params['item_details'] as &$item) {
                if (isset($item['price'])) {
                    $item['price'] = (int)$item['price'];
                }
                if (isset($item['name']) && strlen($item['name']) > 50) {
                    $item['name'] = substr($item['name'], 0, 47) . '...';
                }
            }
        }
        
        // Ensure customer_details exists
        if (!isset($params['customer_details'])) {
            $params['customer_details'] = [
                'first_name' => 'Guest Customer',
                'email' => 'guest@example.com',
            ];
        }
    }
    
    /**
     * Create payment transaction parameters
     *
     * @param \App\Models\Transaction $transaction
     * @param \App\Models\Order $order
     * @return array
     */
    public function createTransactionParams($transaction, $order): array
    {
        try {
            // Extract customer details
            $customerName = $order->user->name ?? 'Customer';
            $customerEmail = $order->user->email ?? 'customer@example.com';
            $customerPhone = $order->user_phone ?? '';
            
            // Create unique transaction ID that's URL-safe
            // Format: TRX-{date}-{random}
            $transactionId = 'TRX-' . date('Ymd') . '-' . rand(1000, 9999);
            
            // Update transaction ID in database
            $transaction->transaction_id = $transactionId;
            $transaction->save();
            
            // Ensure amount is integer
            $grossAmount = (int)round($transaction->amount);
            
            $params = [
                'transaction_details' => [
                    'order_id' => $transactionId,
                    'gross_amount' => $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => $customerName,
                    'email' => $customerEmail,
                    'phone' => $customerPhone,
                ],
                'item_details' => [],
                'enabled_payments' => [
                    'credit_card', 'gopay', 'shopeepay', 
                    'bca_va', 'bni_va', 'bri_va', 'permata_va',
                    'indomaret', 'alfamart'
                ],
                'credit_card' => [
                    'secure' => true
                ],
                'callbacks' => [
                    'finish' => route('transaction.finish', $transaction->id),
                ]
            ];
            
            // Add order items to transaction parameters
            foreach ($order->items as $item) {
                $itemName = substr($item->service_name, 0, 50);
                $itemPrice = (int)round($item->price);
                
                $params['item_details'][] = [
                    'id' => (string)$item->service_id,
                    'name' => $itemName,
                    'price' => $itemPrice,
                    'quantity' => $item->quantity,
                ];
            }
            
            return $params;
        } catch (Exception $e) {
            Log::error('Error creating transaction parameters: ' . $e->getMessage());
            throw new Exception('Error creating transaction parameters: ' . $e->getMessage());
        }
    }
    
    /**
     * Process notification from Midtrans
     * @param string $notificationBody
     * @return array
     */
    public function processNotification(string $notificationBody): array
    {
        try {
            $notification = new Notification();
            
            $transactionStatus = $notification->transaction_status;
            $transactionId = $notification->order_id;
            $fraudStatus = $notification->fraud_status;
            $paymentType = $notification->payment_type;
            
            $statusResult = [
                'transaction_id' => $transactionId,
                'status' => 'pending',
                'payment_type' => $paymentType,
                'details' => json_decode($notificationBody, true),
            ];
            
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $statusResult['status'] = 'pending';
                } else if ($fraudStatus == 'accept') {
                    $statusResult['status'] = 'success';
                }
            } else if ($transactionStatus == 'settlement') {
                $statusResult['status'] = 'success';
            } else if (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $statusResult['status'] = 'failed';
            } else if ($transactionStatus == 'pending') {
                $statusResult['status'] = 'pending';
            } else if ($transactionStatus == 'refund') {
                $statusResult['status'] = 'refunded';
            }
            
            return $statusResult;
        } catch (Exception $e) {
            Log::error('Error processing Midtrans notification: ' . $e->getMessage());
            throw new Exception('Error processing Midtrans notification: ' . $e->getMessage());
        }
    }
    
    /**
     * Get transaction status from Midtrans
     *
     * @param string $transactionId
     * @return array
     */
    public function getTransactionStatus(string $transactionId): array
    {
        try {
            $response = Transaction::status($transactionId);
            $responseData = json_decode(json_encode($response), true);
            
            $status = 'pending';
            
            // Map transaction status
            $transactionStatus = $responseData['transaction_status'] ?? '';
            $fraudStatus = $responseData['fraud_status'] ?? null;
            
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $status = 'pending';
                } else if ($fraudStatus == 'accept') {
                    $status = 'success';
                }
            } else if ($transactionStatus == 'settlement') {
                $status = 'success';
            } else if (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $status = 'failed';
            } else if ($transactionStatus == 'pending') {
                $status = 'pending';
            } else if ($transactionStatus == 'refund') {
                $status = 'refunded';
            }
            
            return [
                'transaction_id' => $transactionId,
                'status' => $status,
                'payment_type' => $responseData['payment_type'] ?? null,
                'details' => $responseData,
            ];
        } catch (Exception $e) {
            Log::error('Error getting transaction status: ' . $e->getMessage());
            throw new Exception('Error getting transaction status: ' . $e->getMessage());
        }
    }
}