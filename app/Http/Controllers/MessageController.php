<?php

namespace App\Http\Controllers;

use App\Mail\NewMessageNotification;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $unreadCount = Message::where('is_read', false)->count();

        $messages = Message::query()
            ->when($filter === 'unread', fn ($q) => $q->where('is_read', false))
            ->when($filter === 'read', fn ($q) => $q->where('is_read', true))
            ->latest()
            ->get();

        return view('admin.message.index', compact('messages', 'filter', 'unreadCount'));
    }

    public function show(Message $message)
    {
        return view('admin.message.show', compact('message'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $message = Message::create($validated);

        // kirim email ke admin
        Mail::to('arifrahmanhakim@gmail.com')->send(new NewMessageNotification($message));

        return back()->with('success', 'message sent successfully.');
    }

    public function markAsRead(Message $message)
    {
        $message->update(['is_read' => true]);

        return redirect()->route('message.index')->with('success', 'message marked as read.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('message.index')->with('success', 'message deleted successfully.');
    }

    public function destroyAll()
    {
        Message::truncate(); // hapus semua data

        return redirect()->route('message.index')->with('success', 'All messages deleted successfully.');
    }
}
