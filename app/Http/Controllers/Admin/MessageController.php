<?php

namespace App\Http\Controllers\Admin;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Apartment;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Apartment $apartment)
    {
        // schermata per mostrare tutti i messaggi
        $messages = Message::orderBy('email')->orderByDesc('created_at')->where('apartment_id', $apartment->id)->get();
        $apartmentName = $apartment->summary;
        return view('admin.messages.index', compact('messages', 'apartmentName'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Message $message)
    {
        // permette di eliminare il messaggio
        $message->delete();
        return redirect()->route('admin.messages.index')->with('message', 'Message deleted');
    }
}
