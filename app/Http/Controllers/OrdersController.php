<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Orders_item;
use App\Models\Carts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmation;

class OrdersController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required',
            'payment_method' => 'required|in:cod,vnpay,momo',
        ]);
        $user = Auth::user();
        $cartItems = Carts::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng trống');
        }

        DB::beginTransaction();

        try {
            $totalPrice = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            $order = Orders::create([
                'user_id' => $user->id,
                'address_id' => $request->address_id,
                'payment_method' => $request->payment_method,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                Orders_item::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);
            }

            Carts::where('user_id', $user->id)->delete();

            DB::commit();

            switch ($request->payment_method) {
                case 'cod':
                    $orderItems = $order->orderItems;
                    foreach ($orderItems as $orderItem) {
                        $product = $orderItem->product;
                        $product->quantity -= $orderItem->quantity;
                        $product->save();
                    }
                    Mail::to($user->email)->send(new PaymentConfirmation($order));
                    return redirect()->route('alert.success', $order->id)->with('success', 'Thêm đơn hàng thành công!');
                    break;
                case 'vnpay':
                    $vnpayUrl = $this->generateVnpayUrl($order, $totalPrice);
                    return redirect()->away($vnpayUrl);
                    break;
                case 'momo':
                    $momoUrl = $this->generateMomoUrl($order, $totalPrice);
                    return redirect()->away($momoUrl);
                    break;
                default:
                    throw new \Exception('Phương thức thanh toán không hợp lệ');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('alert.fail')->with('error', 'Có lỗi khi thêm đơn hàng: ' . $e->getMessage());
        }
    }

    public function show(Orders $orders)
    {
        //
    }

    public function edit(Orders $orders)
    {
        //
    }

    public function update(Request $request, Orders $orders)
    {
        //
    }

    public function destroy(Orders $orders)
    {
        //
    }

    private function generateVnpayUrl($order, $amount)
    {
        $vnp_TmnCode = env('VNPAY_TMN_CODE');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $vnp_Url = env('VNPAY_URL');
        $vnp_Returnurl = route('vnpay.callback');

        $vnp_TxnRef = $order->id;
        $vnp_OrderInfo = "Thanh toán đơn hàng #$vnp_TxnRef";
        $vnp_Amount = $amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "250000",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $hashdata = $query . "&vnp_SecureHash=" . hash_hmac('sha512', $query, $vnp_HashSecret);

        return $vnp_Url . "?" . $hashdata;
    }

    // Hàm tạo URL thanh toán MoMo
    private function generateMomoUrl($order, $amount)
    {
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');
        $endpoint = env('MOMO_URL', 'https://test-payment.momo.vn/v2/gateway/api/create');

        $orderId = $order->id;
        $orderInfo = "Thanh toán đơn hàng #$orderId";
        $redirectUrl = route('momo.callback');
        $ipnUrl = route('momo.ipn');

        $requestId = time() . "";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=&ipnUrl=" . $ipnUrl .
            "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode .
            "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=captureWallet";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Your Store Name",
            'storeId' => "Your Store ID",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => '',
            'requestType' => 'captureWallet',
            'signature' => $signature,
        ];

        $response = $this->execPostRequest($endpoint, json_encode($data));
        $result = json_decode($response, true);

        return $result['payUrl'] ?? abort(500, 'Không thể tạo URL thanh toán MoMo');
    }

    // Hàm gửi POST request cho MoMo
    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    // Callback cho VNPay
    public function vnpayCallback(Request $request)
    {
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'];

        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);

        $hashData = '';
        foreach ($inputData as $key => $value) {
            $hashData .= ($hashData ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            $order = Orders::where('id', $inputData['vnp_TxnRef'])->first();

            if ($order) {
                $responseCode = $inputData['vnp_ResponseCode'];

                if ($responseCode === "00") {
                    $order->status = 'paid';
                    $order->save();

                    $orderItems = $order->orderItems;
                    foreach ($orderItems as $orderItem) {
                        $product = $orderItem->product;
                        if ($product) {
                            $product->quantity -= $orderItem->quantity;
                            $product->save();
                        }
                    }

                    $user = $order->user;
                    if ($user && !empty($user->email)) {
                        $order->email = $user->email;
                        Mail::to($order->email)->send(new PaymentConfirmation($order));
                    }

                    return redirect()->route('alert.success');
                } else {
                    $order->status = ($responseCode === "24") ? 'canceled' : 'fail';
                    $order->save();
                    return redirect()->route('alert.fail');
                }
            } else {
                return redirect()->route('alert.fail');
            }
        } else {
            return redirect()->route('alert.fail');
        }
    }

    // Callback cho MoMo
    public function momoCallback(Request $request)
    {
        $secretKey = env('MOMO_SECRET_KEY');
        $accessKey = env('MOMO_ACCESS_KEY');

        $data = $request->all();

        Log::info('MoMo Callback Data: ', $data);

        $extraData = $data['extraData'] ?? '';
        $rawSignature = "accessKey=" . $accessKey .
            "&amount=" . $data['amount'] .
            "&extraData=" . $extraData .
            "&message=" . $data['message'] .
            "&orderId=" . $data['orderId'] .
            "&orderInfo=" . $data['orderInfo'] .
            "&orderType=" . $data['orderType'] .
            "&partnerCode=" . $data['partnerCode'] .
            "&payType=" . $data['payType'] .
            "&requestId=" . $data['requestId'] .
            "&responseTime=" . $data['responseTime'] .
            "&resultCode=" . $data['resultCode'] .
            "&transId=" . $data['transId'];

        $calculatedSignature = hash_hmac('sha256', $rawSignature, $secretKey);

        $failedCodes = ['-1000', '-1001', '-1002', '-1003', '-1004', '-1005', '-1006', '-1007', '-1008', '-1009'];

        if ($calculatedSignature === $data['signature']) {
            $order = Orders::where('id', $data['orderId'])->first();

            if ($order) {
                if (in_array($data['resultCode'], $failedCodes)) {
                    Log::error('Payment failed', ['orderId' => $data['orderId'], 'resultCode' => $data['resultCode']]);
                    return redirect()->route('alert.fail');
                }

                if ($data['resultCode'] == 0) {
                    $order->status = 'paid';
                    $order->save();

                    $orderItems = $order->orderItems;
                    foreach ($orderItems as $orderItem) {
                        $product = $orderItem->product;
                        if ($product) {
                            $product->quantity -= $orderItem->quantity;
                            $product->save();
                        }
                    }

                    $user = $order->user;
                    if ($user && !empty($user->email)) {
                        $order->email = $user->email;
                        Mail::to($order->email)->send(new PaymentConfirmation($order));
                    }

                    return redirect()->route('alert.success');
                } else {
                    Log::error('Payment failed', ['orderId' => $data['orderId'], 'resultCode' => $data['resultCode']]);
                    return redirect()->route('alert.fail');
                }
            } else {
                Log::error('Order not found', ['orderId' => $data['orderId']]);
                return redirect()->route('alert.fail');
            }
        } else {
            Log::error('Invalid signature', [
                'calculated' => $calculatedSignature,
                'received' => $data['signature'],
                'rawSignature' => $rawSignature
            ]);
            return redirect()->route('alert.fail');
        }
    }

    public function momoIpn(Request $request)
    {
        $secretKey = env('MOMO_SECRET_KEY');
        $accessKey = env('MOMO_ACCESS_KEY');

        $data = $request->all();
        $rawSignature = "accessKey=" . $accessKey .
            "&amount=" . $data['amount'] .
            "&extraData=" . ($data['extraData'] ?? '') .
            "&message=" . $data['message'] .
            "&orderId=" . $data['orderId'] .
            "&orderInfo=" . $data['orderInfo'] .
            "&orderType=" . $data['orderType'] .
            "&partnerCode=" . $data['partnerCode'] .
            "&payType=" . $data['payType'] .
            "&requestId=" . $data['requestId'] .
            "&responseTime=" . $data['responseTime'] .
            "&resultCode=" . $data['resultCode'] .
            "&transId=" . $data['transId'];

        $calculatedSignature = hash_hmac('sha256', $rawSignature, $secretKey);

        if ($calculatedSignature === $data['signature']) {
            $order = Orders::where('id', $data['orderId'])->first();
            if ($order && $data['resultCode'] == 0) {
                $order->status = 'paid';
                $order->save();
            }
        }
    }
}
