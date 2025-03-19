<?php
require 'vendor/autoload.php';
use Vimeo\Vimeo;
use Dotenv\Dotenv;

header('Content-Type: application/json');

// 🔹 Load .env filen
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 🔹 Hent værdier fra .env filen
$client_id = $_ENV['VIMEO_CLIENT_ID'];
$client_secret = $_ENV['VIMEO_CLIENT_SECRET'];
$access_token = $_ENV['VIMEO_ACCESS_TOKEN'];

// 🔹 Opret forbindelse til Vimeo API
$vimeo = new Vimeo($client_id, $client_secret, $access_token);

// 🔹 Håndter video-upload fra AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["video"])) {
    $videoFile = $_FILES["video"]["tmp_name"];
    $videoSize = $_FILES["video"]["size"];

    // 🚨 Tjek om filen overstiger 100MB (100 * 1024 * 1024 bytes)
    if ($videoSize > 100 * 1024 * 1024) {
        echo json_encode(["success" => false, "error" => "Videoen er for stor. Maksimum størrelse er 100MB."]);
        exit;
    }

    // 🔹 Hent offentlig IP fra en ekstern API
    $external_ip = @file_get_contents("https://api64.ipify.org?format=json");
    $external_ip_data = json_decode($external_ip, true);
    $user_ip = $external_ip_data['ip'] ?? $_SERVER['REMOTE_ADDR']; // Brug fallback til lokal IP

    // 🔹 Brug ip-api.com til at få landekode og landenavn
    $geoData = @file_get_contents("http://ip-api.com/json/{$user_ip}?fields=countryCode,country");
    $geoInfo = json_decode($geoData, true);

    // Hent landekode og landenavn
    $countryCode = $geoInfo['countryCode'] ?? 'UKN'; // Hvis API fejler, brug UKN
    $countryName = $geoInfo['country'] ?? 'Unknown'; // Hvis API fejler, brug Unknown

    // 🔹 Generér videotitel med dato & tid
    date_default_timezone_set('Europe/Copenhagen');
    $dateTitle = "Vimeo Video ({$countryCode}) - " . date("Y-m-d H:i:s");

    try {
        // 🔹 Upload video til Vimeo
        $video_uri = $vimeo->upload($videoFile, [
            "name" => $dateTitle,
            "description" => "Automatisk uploadet video fra {$countryName} via API"
        ]);

        if ($video_uri) {
            // 🔹 Hent detaljer om videoen (inkl. hash-delen)
            $video_data = $vimeo->request($video_uri);
            $video_url = $video_data['body']['link'] ?? "https://vimeo.com" . str_replace("/videos/", "/", $video_uri);

            echo json_encode([
                "success" => true,
                "video_url" => $video_url
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "Fejl under upload."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => "Fejl: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Ingen video valgt."]);
}
?>