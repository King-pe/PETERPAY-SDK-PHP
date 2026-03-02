<?php
/**
 * PeterPay PHP SDK
 * Rahisisha malipo ya simu kwenye mfumo wako.
 * 
 * Jinsi ya kutumia:
 * $pay = new PeterPay("API_KEY_YAKO");
 * $res = $pay->createOrder(1000, "2557XXXXXXXX");
 */
class PeterPay {
    private $apiKey;
    private $baseUrl;

    public function __construct($apiKey, $baseUrl = 'https://www.peterpay.link') {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Tuma ombi la malipo (Push USSD)
     */
    public function createOrder($amount, $phone, $name = 'Mteja', $email = '') {
        $endpoint = $this->baseUrl . '/api/v1/create_order';
        $data = [
            'amount' => $amount,
            'buyer_phone' => $phone,
            'buyer_name' => $name,
            'buyer_email' => $email
        ];
        return $this->sendRequest($endpoint, $data);
    }

    /**
     * Angalia hali ya muamala
     */
    public function checkStatus($orderId) {
        $endpoint = $this->baseUrl . '/api/v1/order_status';
        $data = ['order_id' => $orderId];
        return $this->sendRequest($endpoint, $data);
    }

    private function sendRequest($url, $data) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "X-API-KEY: " . $this->apiKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        // curl_close($ch); // Imeondolewa ili kuzuia onyo kwenye PHP 8+

        if ($error) {
            return ['status' => 'error', 'message' => $error];
        }

        return json_decode($response, true);
    }
}
?>