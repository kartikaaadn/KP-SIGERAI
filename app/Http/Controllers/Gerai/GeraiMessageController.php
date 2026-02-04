<?php

namespace App\Http\Controllers\Gerai;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeraiMessageController extends Controller
{
    // Halaman Pesan (Gerai)
    public function index(Request $request)
    {
        $user = Auth::user();

        // pastikan user punya gerai_id
        if (!$user->gerai_id) {
            abort(403, 'Akun ini belum terhubung ke gerai.');
        }

        // Ambil / buat conversation untuk gerai ini
        $conversation = Conversation::firstOrCreate(
            ['gerai_id' => $user->gerai_id],
            ['last_message_at' => now()]
        );

        // Ambil semua pesan dalam conversation
        $messages = Message::where('conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // template cepat (untuk dropdown nanti)
        $templates = [
            'Laporan data hari ini telah di upload.',
            'Laporan mingguan sudah selesai, mohon pengecekan.',
            'Mohon bantuan verifikasi laporan periode ini.',
            'Ada kendala pada input data, mohon arahan.',
        ];

        return view('gerai.pesan.index', compact('conversation', 'messages', 'templates'));
    }

    // Kirim pesan dari gerai
    public function send(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:conversations,id'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $user = Auth::user();

        // validasi conversation harus milik gerai user ini
        $conversation = Conversation::where('id', $request->conversation_id)
            ->where('gerai_id', $user->gerai_id)
            ->firstOrFail();

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_user_id' => $user->id,
            'message' => $request->message,
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        return redirect()->route('gerai.pesan.index');
    }
}
