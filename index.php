<!DOCTYPE html>
<html lang="da">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vimeo Video Upload</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    #loading {
        display: none;
        font-size: 18px;
        color: #333;
    }
    </style>
</head>

<body>
    <h2>Upload en video til Vimeo (Max 100MB)</h2>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="video" id="videoInput" accept="video/*" required>
        <button type="submit">Upload</button>
    </form>
    <div id="loading">⏳ Videoen uploades... Vent venligst.</div>
    <div id="result"></div>

    <script>
    $(document).ready(function() {
        $("#uploadForm").on("submit", function(e) {
            e.preventDefault();
            var file = $("#videoInput")[0].files[0];

            // 🚨 Tjek filstørrelsen (100MB = 100 * 1024 * 1024 bytes)
            if (file.size > 100 * 1024 * 1024) {
                $("#result").html("❌ Fejl: Filen er for stor. Maksimum tilladt størrelse er 100MB.");
                return;
            }

            var formData = new FormData(this);
            $("#loading").show();
            $("#result").html("");

            $.ajax({
                url: "upload_vimeo.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#loading").hide();
                    var data = typeof response === "string" ? JSON.parse(response) :
                        response;
                    if (data.success) {
                        $("#result").html("✅ Video uploadet! <a href='" + data.video_url +
                            "' target='_blank'>" + data.video_url + "</a>");
                    } else {
                        $("#result").html("❌ Fejl: " + (data.error ? data.error :
                            "Ukendt fejl"));
                    }
                },
                error: function(xhr) {
                    $("#loading").hide();
                    $("#result").html("❌ Fejl under upload.");
                    console.error("AJAX error:", xhr.responseText);
                }
            });
        });
    });
    </script>
</body>

</html>