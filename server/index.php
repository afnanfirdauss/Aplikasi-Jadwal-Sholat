
<?php

// ======================================
// AL-HILAL - RPC SERVER
// ======================================

header("Content-Type: application/json; charset=UTF-8");

// Hanya menerima HTTP POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    echo json_encode([
        "jsonrpc" => "2.0",
        "error" => [
            "code" => -32600,
            "message" => "Method HTTP tidak diizinkan"
        ],
        "id" => null
    ]);

    exit;
}

// Mengambil request dari client
$request = json_decode(file_get_contents("php://input"), true);

$requestId = $request['id'] ?? null;

// Fungsi utama mengambil jadwal sholat
function getPrayerSchedule($city, $date)
{
    if (trim($city) === '') {
        throw new Exception("Nama kota wajib diisi");
    }

    $dateObject = DateTime::createFromFormat('!Y-m-d', $date);

    if (!$dateObject || $dateObject->format('Y-m-d') !== $date) {
        throw new Exception("Format tanggal tidak valid");
    }

    // Mengubah format tanggal untuk API
    $formattedDate = $dateObject->format('d-m-Y');

    // Endpoint Aladhan API
    $url = "https://api.aladhan.com/v1/timingsByCity/"
        . $formattedDate
        . "?city=" . urlencode($city)
        . "&country=Indonesia&method=20";

    // Mengirim request API menggunakan CURL
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => true
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);

    curl_close($curl);

    if ($response === false) {
        throw new Exception("Koneksi API gagal: " . $curlError);
    }

    if ($httpCode !== 200) {
        throw new Exception("API gagal memberikan data");
    }

    $result = json_decode($response, true);

    if (
        !isset($result['data']['timings']) ||
        ($result['code'] ?? 0) != 200
    ) {
        throw new Exception("Data jadwal sholat tidak ditemukan");
    }

    $timings = $result['data']['timings'];

    return [
        "city" => $city,
        "date" => $date,
        "timezone" => $result['data']['meta']['timezone'] ?? null,
        "fajr" => $timings['Fajr'],
        "sunrise" => $timings['Sunrise'],
        "dhuhr" => $timings['Dhuhr'],
        "asr" => $timings['Asr'],
        "maghrib" => $timings['Maghrib'],
        "isha" => $timings['Isha']
    ];
}

// ======================================
// SERVER STUB
// ======================================

try {

    if (
        !is_array($request) ||
        ($request['jsonrpc'] ?? null) !== '2.0' ||
        !isset($request['method'])
    ) {
        throw new Exception("Request JSON-RPC tidak valid");
    }

    $method = $request['method'];
    $params = $request['params'] ?? [];

    // Memanggil fungsi berdasarkan method
    switch ($method) {

        case "getPrayerSchedule":

            $result = getPrayerSchedule(
                $params['city'] ?? '',
                $params['date'] ?? ''
            );

            $response = [
                "jsonrpc" => "2.0",
                "result" => $result,
                "id" => $requestId
            ];

            break;

        default:

            http_response_code(404);

            $response = [
                "jsonrpc" => "2.0",
                "error" => [
                    "code" => -32601,
                    "message" => "Method tidak ditemukan"
                ],
                "id" => $requestId
            ];
    }

} catch (Throwable $e) {

    http_response_code(400);

    $response = [
        "jsonrpc" => "2.0",
        "error" => [
            "code" => -32603,
            "message" => $e->getMessage()
        ],
        "id" => $requestId
    ];
}

// Mengirim response ke client
echo json_encode($response);

?>
