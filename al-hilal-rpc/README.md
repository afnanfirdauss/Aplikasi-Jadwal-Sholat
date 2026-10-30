# Al-Hilal

Sistem Informasi Jadwal Sholat berbasis Remote Procedure Call (RPC).

## Teknologi
- PHP Native
- HTML5, CSS3, dan JavaScript
- JSON-RPC 2.0 melalui HTTP
- Aladhan Prayer Times API
- XAMPP

## Struktur folder saat ini

```text
RPC-JADWAL-SHOLAT/
├── al-hilal-rpc/
│   ├── client/
│   │   ├── index.php
│   │   ├── rpc_client.php
│   │   └── assets/
│   │       ├── css/style.css
│   │       ├── js/script.js
│   │       └── images/
│   └── README.md
└── server/
    └── index.php
```

## Instalasi dan menjalankan

1. Ekstrak folder `RPC-JADWAL-SHOLAT` ke `C:\xampp\htdocs\`.
2. Buka XAMPP Control Panel dan jalankan Apache.
3. Pastikan ekstensi PHP cURL aktif di `php.ini` (`extension=curl`).
4. Pastikan komputer terhubung ke internet agar server dapat mengakses Aladhan API.
5. Buka alamat berikut di browser:

   `http://localhost/RPC-JADWAL-SHOLAT/al-hilal-rpc/client/`

## Arsitektur RPC

Browser → `client/assets/js/script.js` → `client/rpc_client.php`
→ HTTP/JSON-RPC 2.0 → `server/index.php` → Aladhan API
→ response JSON → dashboard Al-Hilal.

## Catatan

Folder `server` pada struktur ini berada sejajar dengan folder `al-hilal-rpc`.
Karena itu, alamat server pada `client/rpc_client.php` harus menunjuk ke:

`http://localhost/RPC-JADWAL-SHOLAT/server/index.php`
