# PeterPay SDK PHP - Rahisisha Malipo ya Simu Tanzania

Karibu kwenye **PeterPay SDK PHP**, chombo rahisi na chenye nguvu cha kuunganisha mifumo ya malipo ya simu (M-Pesa, Tigo Pesa, Airtel Money, HaloPesa) kwenye tovuti au mfumo wako wa PHP. 

SDK hii imeundwa na **Peter Joram** ili kurahisisha mchakato wa kutuma maombi ya malipo (Push USSD) na kuangalia hali ya miamala kwa kutumia API ya [PeterPay](https://www.peterpay.link).

---

## 🚀 Sifa Kuu
- **Push USSD (STK Push):** Tuma ombi la malipo moja kwa moja kwenye simu ya mteja.
- **Hali ya Muamala:** Angalia kama mteja amelipia au ameahirisha.
- **Webhook Integration:** Pokea taarifa za malipo papo hapo kwenye mfumo wako.
- **Sandbox Mode:** Jaribu mfumo wako kabla ya kuanza kupokea malipo halisi.

---

## 🛠 Mahitaji
- PHP 7.4 au zaidi.
- Extension ya `curl` iwe imewashwa (enabled).
- API Key kutoka [PeterPay Dashboard](https://www.peterpay.link).

---

## 📦 Ufungaji (Installation)

Pakua faili la `PeterPaySDK.php` na uliweke kwenye folda ya mradi wako. Kisha, liunganishe kwenye kodi yako:

```php
require_once 'PeterPaySDK.php';
```

---

## 💡 Jinsi ya Kutumia

### 1. Kuanzisha SDK (Initialization)
Tumia API Key yako uliyopewa kwenye dashboard ya PeterPay.

```php
use PeterPay\SDK\PeterPay; // Kama unatumia namespace, vinginevyo tumia class moja kwa moja

$apiKey = "API_KEY_YAKO_HAPA";
$pay = new PeterPay($apiKey);
```

### 2. Kutuma Ombi la Malipo (Create Order)
Hii itatuma Push USSD kwenye simu ya mteja.

```php
$amount = 1000; // Kiasi cha fedha (TZS)
$phone = "2557XXXXXXXX"; // Namba ya simu ya mteja
$name = "Juma Hamisi"; // Jina la mteja (Optional)
$email = "juma@example.com"; // Barua pepe (Optional)

$response = $pay->createOrder($amount, $phone, $name, $email);

if ($response['status'] === 'success') {
    $orderId = $response['data']['order_id'];
    echo "Ombi la malipo limetumwa! Order ID: " . $orderId;
} else {
    echo "Hitilafu: " . $response['message'];
}
```

### 3. Kuangalia Hali ya Muamala (Check Status)
Unaweza kutumia `order_id` uliyopewa wakati wa kutengeneza oda.

```php
$orderId = "API-XXXXXX";
$status = $pay->checkStatus($orderId);

if ($status['status'] === 'success') {
    echo "Hali ya Malipo: " . $status['data']['payment_status'];
} else {
    echo "Imeshindikana kupata hali ya muamala.";
}
```

---

## 🔗 Webhook Integration
Ili kupokea taarifa za malipo papo hapo mteja anapomaliza kulipia, unapaswa kuweka **Webhook URL** kwenye mipangilio yako ya PeterPay.

Mfano wa kupokea webhook kwenye PHP:

```php
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

if ($data && $data['event'] === 'payment.completed') {
    $orderId = $data['order_id'];
    $amount = $data['amount'];
    
    // Update database yako hapa
    // ...
    
    http_response_code(200);
    echo json_encode(['status' => 'received']);
}
```

---

## 🛡 Usalama (Security)
PeterPay inatuma sahihi (Signature) kwenye header ya webhook kwa ajili ya usalama. Unaweza kuithibitisha kwa kutumia `API Secret` yako.

```php
$signature = $_SERVER['HTTP_X_PETERPAY_SIGNATURE'] ?? '';
$calculated_sig = hash_hmac('sha256', $payload, $your_api_secret);

if (hash_equals($calculated_sig, $signature)) {
    // Muamala ni halali na umetoka PeterPay
}
```

---

## 👨‍💻 Imetengenezwa na
**Peter Joram**  
Tovuti: [www.peterpay.link](https://www.peterpay.link)

Kwa msaada zaidi, wasiliana nasi kupitia tovuti yetu au fungua *Issue* hapa GitHub.

---

## 📄 Leseni (License)
Mradi huu upo chini ya leseni ya MIT. Angalia faili la [LICENSE](LICENSE) kwa maelezo zaidi.
