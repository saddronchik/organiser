<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Alert;

use App\Models\Event;
use Exception;
use Illuminate\Support\Facades\DB;

class FullCalenderController extends Controller
{
    public function index(){
       
        $event=Event::all();

        return response()->json($event,200);
    }

    public function indexall(){
        $events=Event::all();
        $eventsStatus = DB::table('events')
        ->where('status','В работе')
        ->get();
        return view('welcome',['events'=>$events,'eventsStatus'=>$eventsStatus]);
    }


	public function store(Request $request){
	try{
		$validator = Validator::make($request->all(),[
			'title'=>'required',
			'color'=>'required'
		]);
		if ($validator->fails()) {
			Alert::error('Ошибка!',$validator->messages()->first());
			return redirect()->back();
		}else {
            if(empty($request->event_id)){
                  
			Event::create($request->all());
			Alert::success('Ура','Событие успешно добавлено');
			return redirect()->back();
		}else {
           Event::where('id',$request->event_id)->update([
               'title'=>$request->title,
               'start'=>$request->start2_,
               'end'=>$request->end2,
               'color'=>$request->color,
               'status'=>$request->status,
               'description'=>$request->description,
               'assigned'=>$request->assigned,
           ]);
           Alert::success('Ура','Событие обновленно');
           return redirect()->back();
        }
    }
    }
    catch(Exception $e){
       Alert::error("Ошибка","Заполните поля корректно!");
        return redirect()->back();
    }
	}

    public function eventCheck($id){
        $check_event = Event::where('id',$id)
        ->update(['readed'=>1]);
        if (!$check_event) {
            return response()->json([
                "status"=>false
            ]);
        }else {
            return response()->json([
                "status"=>true
            ]);
        }
    }

    public function countEvents()
    {
        $eventInWokrs = Event::where('status', 'В работе')
        ->count();
        $eventNotChecked = Event::where('status', 'В работе')
        ->whereNull('readed')
        ->count();
        return response()->json([
            "eventInWokrs" => $eventInWokrs,
            "eventNotChecked" => $eventNotChecked,
        ]);
    }

    public function delete($id){
        Event::destroy($id);
        return redirect()->back();
    }



}