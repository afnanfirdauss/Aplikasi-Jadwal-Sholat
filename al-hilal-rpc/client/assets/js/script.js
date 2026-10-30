
// ======================================
// AL-HILAL - JAVASCRIPT
// ======================================

const prayerForm = document.getElementById("prayerForm");
const searchButton = document.getElementById("searchButton");
const notification = document.getElementById("notification");

const rpcStatus = document.getElementById("rpcStatus");
const rpcDetail = document.getElementById("rpcDetail");
const locationInfo = document.getElementById("locationInfo");

// Mengisi tanggal hari ini
const dateInput = document.getElementById("date");

const today = new Date();

const localDate =
    today.getFullYear() + "-" +
    String(today.getMonth() + 1).padStart(2, "0") + "-" +
    String(today.getDate()).padStart(2, "0");

dateInput.value = localDate;

// Menampilkan notifikasi
function showNotification(message, type) {
    notification.textContent = message;

    notification.className = "notification " + type;
}

// Mengubah status RPC
function updateRPCStatus(status, detail) {
    rpcStatus.innerHTML =
        '<span class="status-dot"></span>' + status;

    rpcDetail.textContent = detail;
}

// Menampilkan jadwal sholat
function displaySchedule(data) {

    document.getElementById("fajr").textContent = data.fajr;
    document.getElementById("sunrise").textContent = data.sunrise;
    document.getElementById("dhuhr").textContent = data.dhuhr;
    document.getElementById("asr").textContent = data.asr;
    document.getElementById("maghrib").textContent = data.maghrib;
    document.getElementById("isha").textContent = data.isha;

    locationInfo.textContent =
        data.city + " | " + data.date +
        (data.timezone ? " | " + data.timezone : "");
}

// Proses pencarian jadwal sholat
async function getPrayerSchedule(city, date) {

    searchButton.disabled = true;
    searchButton.textContent = "Mengambil Data...";

    updateRPCStatus(
        "Connecting",
        "Mengirim request JSON-RPC ke server..."
    );

    try {

        // Memanggil Client Stub
        const response = await fetch("rpc_client.php", {

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({
                city: city,
                date: date
            })

        });

        const result = await response.json();

        if (!response.ok || result.error) {
            throw new Error(
                result.error?.message ||
                result.error ||
                "Terjadi kesalahan pada server"
            );
        }

        if (!result.result) {
            throw new Error("Response RPC tidak valid");
        }

        // Menampilkan hasil response RPC
        displaySchedule(result.result);

        showNotification(
            "Jadwal sholat berhasil diambil dari server!",
            "success"
        );

        updateRPCStatus(
            "Connected",
            "JSON-RPC 2.0 berhasil. Request ID: " + result.id
        );

    } catch (error) {

        showNotification(
            error.message,
            "error"
        );

        updateRPCStatus(
            "Connection Failed",
            "Komunikasi RPC gagal."
        );

    } finally {

        searchButton.disabled = false;
        searchButton.innerHTML =
            "<span>⌕</span> Tampilkan Jadwal";

    }
}

// Event ketika form dikirim
prayerForm.addEventListener("submit", function(event) {

    event.preventDefault();

    const city = document.getElementById("city").value.trim();
    const date = dateInput.value;

    if (!city || !date) {

        showNotification(
            "Silakan isi kota dan tanggal terlebih dahulu.",
            "error"
        );

        return;
    }

    getPrayerSchedule(city, date);

});

// Otomatis mengambil jadwal awal
getPrayerSchedule("Tasikmalaya", localDate);
