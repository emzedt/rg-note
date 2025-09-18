<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\NoteViewHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Logika untuk Sapaan Dinamis ---
        $hour = Carbon::now()->hour;
        if ($hour < 12) {
            $greeting = 'Good morning';
        } elseif ($hour < 18) {
            $greeting = 'Good afternoon';
        } else {
            $greeting = 'Good evening';
        }

        // --- Logika untuk Mengambil Catatan Terbaru ---
        // Ambil aktivitas terakhir yang dimiliki oleh user yang sedang login
        $histories = NoteViewHistory::where('user_id', auth()->id())
            ->with('note.user')      // Ambil data note & pemiliknya sekaligus
            ->latest('updated_at')  // Urutkan dari yang terbaru dilihat
            ->get()
            ->unique('note_id')     // Ambil hanya 1 history terakhir per note
            ->values();

        return view('dashboard', compact('greeting', 'histories'));
    }
}
