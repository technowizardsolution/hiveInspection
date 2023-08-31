<?php

namespace App\Http\Controllers\Admin;

use App\Chat;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index()
    {
        // Get all users except current logged in
        $users = User::where('id', '!=', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(8);
        return view('admin.app.inicio', compact('users'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('entrar');
    }

    public function usersChat($userName)
    {
        $receptorUser = User::where('id', '=', $userName)->first();
        if ($receptorUser == null) {
            return view('admin.app.nousernamefinded', compact('userName'));
        } else {
            $users = User::where('id', '!=', Auth::user()->id)->take(10)->get();
            $chat = $this->hasChatWith($receptorUser->id);
            return view('admin.app.chat', compact('receptorUser', 'chat', 'users'));
        }
    }

    public function hasChatWith($userId)
    {
        $chat = Chat::where('user_id1', Auth::user()->id)
            ->where('user_id2', $userId)
            ->orWhere('user_id1', $userId)
            ->where('user_id2', Auth::user()->id)
            ->get();
        if (!$chat->isEmpty()) {
            return $chat->first();
        } else {
            return $this->createChat(Auth::user()->id, $userId);
        }
    }

    public function createChat($userId1, $userId2)
    {
        $chat = Chat::create([
            'user_id1' => $userId1,
            'user_id2' => $userId2,
        ]);
        return $chat;
    }
}
