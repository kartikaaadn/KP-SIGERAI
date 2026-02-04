<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Gerai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMessageController extends Controller
{
    // Halaman Pesan (Admin)
    public function index(Request $request)
    {
        // Ambil semua conversation terbaru (biar list kiri tampil)
        $conversations = Conversation::with('gerai')
            ->orderByDesc('last_message_at')
            ->get();

        // Ambil conversation yang dipilih (via query ?c=ID)
        $selectedId = $request->query('c');

        // Kalau belum pilih, ambil yang pertama
        $activeConversation = null;
        if ($selectedId) {
            $activeConversation = Conversation::with('gerai')->where('id', $selectedId)->first();
        }
        if (!$activeConversation) {
            $activeConversation = $conversations->first();
        }

        $messages = collect();
        if ($activeConversation) {
            $messages = Message::where('conversation_id', $activeConversation->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // template cepat untuk admin
        $templates = [
            'Terima kasih, laporan sudah diterima dengan baik.',
            'Mohon lengkapi data laporan yang masih kosong.',
            'Laporan sudah kami cek, silakan lanjut periode berikutnya.',
            'Mohon kirim ulang file laporan karena format tidak sesuai.',
        ];

        return view('admin.pesan.index', compact(
            'conversations',
            'activeConversation',
            'messages',
            'templates'
        ));
    }

    // Kirim pesan dari admin
    public function send(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:conversations,id'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $user = Auth::user();

        // admin boleh kirim ke conversation mana saja
        $conversation = Conversation::where('id', $request->conversation_id)->firstOrFail();

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_user_id' => $user->id,
            'message' => $request->message,
        ]);

        $conversation->update([
            'last_message_at' => now(),
        ]);

        // tetap di conversation yang sama
        return redirect()->route('admin.pesan.index', ['c' => $conversation->id]);
    }
}
