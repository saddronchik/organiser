<?php

namespace App\Http\Controllers;

use App\Events\CheckMessage;
use App\Events\NewMessage;
use App\Events\MessageDelete;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(){

        return response()->json(Message::all());

    }

    public function store(Request $request){

        
       $messages = Message::create([
           
           "username"=>$request->username,
            "message"=>$request->message,
        ]);

        event(new NewMessage($messages->id,$messages->username,$messages->message,$messages->created_at));

        return response()->json([
            "status" => true,
            "message"=> $messages
        ]);


    }
    public function messageCheck(Request $request){
        $request_id = $request->json("body");
       $check_message = Message::where('id',$request_id)
        ->update(['readed'=>1]);
        if (!$check_message) {
            return response()->json([
                "status"=>false
            ]);
        }else {
            event(new CheckMessage($request_id));
            return response()->json([
                "status"=>true
            ]);

        }
    }


    

    public function messageOnDelete(Request $request){
        $request_data = $request->json("body");
        $deleteMessages = Message::destroy($request_data);

        if (!$deleteMessages) {
            return response()->json([
                "status" => false
            ]);
        }else {
            event(new MessageDelete($request_data));
            return response()->json([
                "status" => true,
            ]);
        }
        
    
       
    }
}
