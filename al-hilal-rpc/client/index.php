
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Al-Hilal | Jadwal Sholat</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">

            <a href="#" class="brand">
                <span class="brand-icon">☪</span>
                <span>Al-Hilal</span>
            </a>

            <span class="nav-label">Prayer Time System</span>

        </div>
    </nav>

    <!-- HERO -->
    <main class="container">

        <section class="hero">

            <div class="hero-content">

                <span class="eyebrow">
                    ✦ SISTEM INFORMASI JADWAL SHOLAT
                </span>

                <h1>
                    Waktu Sholat,<br>
                    <span>Pengingat Ibadah.</span>
                </h1>

                <p>
                    Temukan jadwal sholat harian berdasarkan
                    lokasi dan tanggal pilihan Anda.
                </p>

            </div>

            <div class="moon-decoration">☪</div>

        </section>

        <!-- SEARCH -->
        <section class="search-card">

            <div class="section-heading">
                <h2>Cari Jadwal Sholat</h2>
                <p>Pilih lokasi dan tanggal yang ingin Anda cari.</p>
            </div>

            <form id="prayerForm">

                <div class="form-group">

                    <label for="city">Nama Kota</label>

                    <input
                        type="text"
                        id="city"
                        name="city"
                        placeholder="Contoh: Tasikmalaya"
                        value="Tasikmalaya"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="date">Tanggal</label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        required
                    >

                </div>

                <button type="submit" id="searchButton">
                    <span>⌕</span>
                    Tampilkan Jadwal
                </button>

            </form>

        </section>

        <!-- NOTIFICATION -->
        <div id="notification" class="notification hidden"></div>

        <!-- LOCATION INFO -->
        <section class="result-section">

            <div class="result-heading">

                <div>
                    <span class="section-label">JADWAL HARIAN</span>
                    <h2>Waktu Sholat</h2>
                    <p id="locationInfo">Menunggu data lokasi...</p>
                </div>

                <div class="status-badge" id="rpcStatus">
                    <span class="status-dot"></span>
                    RPC Ready
                </div>

            </div>

            <!-- PRAYER CARDS -->
            <div class="prayer-grid">

                <div class="prayer-card">
                    <div class="prayer-icon">🌙</div>
                    <p>Subuh</p>
                    <h3 id="fajr">--:--</h3>
                </div>

                <div class="prayer-card">
                    <div class="prayer-icon">🌅</div>
                    <p>Terbit</p>
                    <h3 id="sunrise">--:--</h3>
                </div>

                <div class="prayer-card">
                    <div class="prayer-icon">☀️</div>
                    <p>Dzuhur</p>
                    <h3 id="dhuhr">--:--</h3>
                </div>

                <div class="prayer-card">
                    <div class="prayer-icon">🌤️</div>
                    <p>Ashar</p>
                    <h3 id="asr">--:--</h3>
                </div>

                <div class="prayer-card">
                    <div class="prayer-icon">🌇</div>
                    <p>Maghrib</p>
                    <h3 id="maghrib">--:--</h3>
                </div>

                <div class="prayer-card">
                    <div class="prayer-icon">🌃</div>
                    <p>Isya</p>
                    <h3 id="isha">--:--</h3>
                </div>

            </div>

        </section>

        <!-- RPC INFORMATION -->
        <section class="rpc-information">

            <div class="rpc-icon">⚙</div>

            <div>
                <h3>RPC Communication</h3>
                <p>
                    Sistem menggunakan JSON-RPC 2.0
                    untuk komunikasi antara client dan server.
                </p>
                <span id="rpcDetail">Menunggu permintaan RPC...</span>
            </div>

        </section>

    </main>

    <!-- FOOTER -->
    <footer class="footer">

        <h3>☪ Al-Hilal</h3>

        <p>
            Sistem Informasi Jadwal Sholat Berbasis
            Remote Procedure Call.
        </p>

        <small>© 2026 Al-Hilal. All Rights Reserved.</small>

    </footer>

    <script src="assets/js/script.js"></script>

</body>
</html>
