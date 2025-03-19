# 🎬 Simpel Vimeo Video Upload med PHP

Dette projekt gør det muligt at uploade videoer til Vimeo ved hjælp af **PHP og Vimeo API**.  
Når en video uploades, returneres **status og et link til videoen**, når den er klar.

### 🚀 Funktioner

✅ Simpel video-upload til Vimeo  
✅ Begrænser filstørrelsen til **max 100MB**  
✅ Viser en "loading"-tekst under upload.  
✅ Returnerer Vimeo-link, når videoen er færdig
✅ Video har fået dato-tid med landekode som titel
✅ Beskrivelsen på video har fået landenavn tilføjet

---

### Krav

Før du bruger dette projekt, skal du have:

- **PHP 7.4 eller nyere**
- **Composer** (til at installere Vimeo SDK)
- **En Vimeo-konto** (Starter, Standard eller højere)
- **En Vimeo App** med OAuth-nøgle

---

### Opsætning

#### 🔹 A. Klon eller download projektet

```bash
git clone https://github.com/cph-pk/vimeo-upload.git
cd vimeo-upload
```

#### 🔹 B. Opret en Vimeo App

1. **Gå til** [Vimeo Developer Site](https://developer.vimeo.com).
2. **Opret en ny app** (kræver en gratis Vimeo-konto).
3. Gå til **"My Apps"** → Klik på din app.
4. Under **"Authentication"**, generer en **Access Token** med følgende scopes:

```cpp
upload, edit, delete, video_files
```

5. Kopiér din **Access Token** (bruges i PHP-script).

#### 🔹 C. Installer afhængigheder med Composer

Installer nødvendige pakker:

```bash
composer require vimeo/vimeo-api
composer require vlucas/phpdotenv
```

- `vimeo/vimeo-api` → Vimeo SDK til PHP
- `vlucas/phpdotenv` → Håndtering af API-nøgler i en `.env`-fil

#### 🔹 D. Opret en .env-fil og tilføj dine Vimeo API-nøgler

```
VIMEO_CLIENT_ID=din_client_id
VIMEO_CLIENT_SECRET=dit_client_secret
VIMEO_ACCESS_TOKEN=dit_access_token
```

💡 **Tip:** Du kan finde disse nøgler i din [Vimeo Developer Portal.](https://developer.vimeo.com/apps)

---

### Kør projektet lokalt

Start en PHP-server i projektmappen:

```bash
php -S localhost:8000
```

Derefter, **åbn i din browser:**

```bash
http://localhost:8000/index.php
```

---

### Hvordan bruger du det?

1. **Vælg en video** i upload-formularen (**max 100MB**).
2. **Tryk "Upload"**, og vent på, at videoen bliver uploadet.
3. **"loading"-tekst** vises mens videoen uploades.
4. **Få Vimeo-linket**, når videoen er klar.

---

### Filstruktur

```bash
/vimeo-upload
│── vendor/               # Composer afhængigheder
│── .env                  # API-nøgler (sikret)
│── index.php             # Upload formular
│── upload_vimeo.php      # Håndterer video-upload
│── README.md             # Dokumentation
│── composer.json         # Composer metadata
│── composer.lock         # Composer afhængigheder
```

---

## Licens

Dette projekt er frit til brug og modifikation.
