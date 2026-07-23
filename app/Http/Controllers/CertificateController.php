<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function download(Registration $registration)
    {
        // Pastikan hanya pemilik registrasi yang bisa download
        if ($registration->user_id !== auth()->id()) {
            abort(403);
        }

        // Pastikan event sudah selesai
        if ($registration->event->status !== 'selesai') {
            return back()->with('error', 'Sertifikat belum tersedia. Acara belum selesai.');
        }

        $pdf = Pdf::loadView('certificates.template', compact('registration'));
        return $pdf->download('sertifikat-' . $registration->event->nama . '.pdf');
    }
}