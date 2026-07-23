<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 60px; border: 10px solid #3b82f6; }
        h1 { font-size: 36px; color: #1b1b18; margin-bottom: 10px; }
        h2 { font-size: 28px; color: #3b82f6; margin: 20px 0; }
        p { font-size: 16px; color: #555; }
        .footer { margin-top: 60px; font-size: 14px; }
    </style>
</head>
<body>
    <h1>SERTIFIKAT FINISHER</h1>
    <p>Diberikan kepada</p>
    <h2>{{ $registration->nama_lengkap }}</h2>
    <p>Atas partisipasinya dalam acara</p>
    <h2>{{ $registration->event->nama }}</h2>
    <p>Kategori {{ $registration->runCategory ? $registration->runCategory->nama : $registration->event->kategori }} · {{ $registration->event->tanggal->translatedFormat('d F Y') }} · {{ $registration->event->kota }}</p>

    <div class="footer">
        <p>No. BIB: {{ $registration->no_bib ?? '-' }}</p>
        <p>Mau Run — Platform Penyelenggara Acara Lari</p>
    </div>
</body>
</html>