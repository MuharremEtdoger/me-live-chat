<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('sender')->get(); // Mesajları ve göndericiyi al
        return response()->json($messages);
    } 
    public function getThisMessages($receiverId){
        $userId = auth()->id();

        $messages = Message::where(function($query) use ($userId, $receiverId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function($query) use ($userId, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc') // Mesajları tarih sırasına göre sırala (isteğe bağlı)
        ->with('sender') // Eğer sender bilgilerini de Vue'de göstermek istiyorsan
        ->get();
    
        return response()->json($messages);  

    }
    public function listOtherUsers()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }       
    public function messageLists(){
        $userId=auth()->id();    
        $messages = Message::select(
            DB::raw('IF(sender_id = '.$userId.', receiver_id, sender_id) as other_user_id'),
            DB::raw('MAX(id) as latest_id')
        )
        ->where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
        })
        ->groupBy('other_user_id')
        ->get()
        ->pluck('latest_id'); // sadece son mesajların id'lerini alıyoruz
    
    // Son mesajları alıyoruz ve sender ilişkisini yüklüyoruz
    $lastMessages = Message::with('sender','receiver')
        ->whereIn('id', $messages)
        ->orderBy('id', 'DESC')
        ->get();
    
    // Kullanıcıya JSON olarak döndür
    return response()->json($lastMessages);
    }
    // Mesaj gönderme fonksiyonu
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        // Mesaj gönderildiğinde Event'i tetikle
        broadcast(new MessageSent($message));

        return back()->with('success', 'Mesaj başarıyla gönderildi!');
    }

    // Kullanıcıya ait mesajları almak için
    public function getMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('receiver_id', Auth::id())->where('sender_id', $userId);
        })->get();

        return view('messages.index', compact('messages', 'userId'));
    }
}
