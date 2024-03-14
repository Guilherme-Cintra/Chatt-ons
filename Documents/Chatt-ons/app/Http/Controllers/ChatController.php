<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Chat;

class ChatController extends Controller
{
    //
    public function create(Request $request){
        $request->validate([
            'user_id'
        ]);

        $user = $request->user();
        $otherUser = User::find($request->user_id);
  
   
        $conversation = Chat::conversations()->between($user, $otherUser);

        if(!isset($conversation)){
            $conversation = Chat::makeDirect()->createConversation([$user, $otherUser]);
        }

        return $conversation; 
    }

  
    public function index(Request $request){
        // direct conversations / messages
        $conversations = Chat::conversations()->setParticipant($request->user())->isDirect()->get();

        return response()->json([
            'conversations'=> $conversations
        ], 201);

    }

    public function sendMessage(Request $request, $id){
        $request->validate([
            'message'=> 'required'
        ]);

        $conversation = Chat::conversations()->getById($id); 

        $message = Chat::message($request->message)
        ->from($request->user())
        ->to($conversation)
        ->send();

        return $message;
    }

    public function getMessages(Request $request, $id){
        $conversation = Chat::conversations()->getById($id); 
       $messages =  Chat::conversation($conversation)
       ->setParticipant($request
       ->user())
       ->getMessages();

       return $messages;
    }

}
