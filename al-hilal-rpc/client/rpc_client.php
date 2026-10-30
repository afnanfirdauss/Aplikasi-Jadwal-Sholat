<?php
// ======================================
// AL-HILAL - RPC CLIENT STUB
// ======================================

header("Content-Type: application/json; charset=UTF-8");

// Hanya menerima POST dari frontend.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "jsonrpc" => "2.0",
        "error" => [
            "code" => -32600,
            "message" => "Metode request tidak diizinkan."
        ],
        "id" => null
    ]);
    exit;
}

// Membaca dan memvalidasi data dari frontend.
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (
    !is_array($data) ||
    empty($data["city"]) ||
    empty($data["date"])
) {
    http_response_code(400);
    echo json_encode([
        "jsonrpc" => "2.0",
        "error" => [
            "code" => -32600,
            "message" => "Kota dan tanggal wajib diisi."
        ],
        "id" => null
    ]);
    exit;
}

// PENTING:
// Berdasarkan struktur folder proyek saat ini, folder server berada
// sejajar dengan folder al-hilal-rpc, bukan di dalam al-hilal-rpc.
$serverURL = "http://localhost/RPC-JADWAL-SHOLAT/server/index.php";

// Membuat request JSON-RPC 2.0.
$request = [
    "jsonrpc" => "2.0",
    "method" => "getPrayerSchedule",
    "params" => [
        "city" => trim($data["city"]),
        "date" => $data["date"]
    ],
    "id" => uniqid("alhilal_", true)
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $serverURL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Accept: application/json"
    ],
    CURLOPT_POSTFIELDS => json_encode($request),
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CONNECTTIMEOUT => 10
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$curlError = curl_error($curl);

curl_close($curl);

// Jika koneksi ke server RPC gagal.
if ($response === false) {
    http_response_code(502);
    echo json_encode([
        "jsonrpc" => "2.0",
        "error" => [
            "code" => -32000,
            "message" => "Server RPC tidak dapat dihubungi. Periksa alamat server dan Apache. Detail: " . $curlError
        ],
        "id" => $request["id"]
    ]);
    exit;
}

// Pastikan server mengembalikan JSON yang valid.
$decodedResponse = json_decode($response, true);

if (!is_array($decodedResponse)) {
    http_response_code(502);
    echo json_encode([
        "jsonrpc" => "2.0",
        "error" => [
            "code" => -32700,
            "message" => "Response server bukan JSON yang valid. Periksa server/index.php."
        ],
        "id" => $request["id"]
    ]);
    exit;
}

// Teruskan status dan response dari server RPC ke frontend.
http_response_code($httpCode ?: 502);
echo json_encode($decodedResponse);
