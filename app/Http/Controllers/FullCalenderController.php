<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Alert;

use App\Models\Event;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class FullCalenderController extends Controller
{
    public function index()
    {

        $event = Event::all();

        return response()->json($event, 200);
    }

    public function indexall()
    {
        $events = Event::all();
        $eventsStatus = DB::table('events')
            ->groupBy('title')
            ->having('status', 'В работе')
            ->get();
        $eventsTogles = DB::table('events')
            ->groupBy('title')
            ->having('typeEvent', 'togle')
            ->get();
        return view('welcome', ['events' => $events, 'eventsStatus' => $eventsStatus, 'eventsTogles'=>$eventsTogles]);
    }


    public function store(Request $request)
    {
        // dd(Carbon::parse($request->end)->addHour(23)->addMinutes(59)->toDateTimeString());
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'color' => 'required'
            ]);
            if ($validator->fails()) {
                Alert::error('Ошибка!', $validator->messages()->first());
                return redirect()->back();
            } else {

                if (empty($request->event_id)) {
                    if ($request->repeated == 1) {
                        for ($i = 0; $i < 5; $i++) {

                            $repeatedEvent = Carbon::parse($request->start)->addYear($i)->toDateTimeString();
                            $repeatedEventEnd = Carbon::parse($request->end)->addYear($i)->toDateTimeString();

                            Event::create([
                                'typeEvent' => $request->typeEvent,
                                'start' => $repeatedEvent,
                                'title' => $request->title,
                                'end' => $repeatedEventEnd,
                                'color' => $request->color,
                                'status' => $request->status,
                                'description' => $request->description,
                                'assigned' => $request->assigned,
                            ]);
                        }

                        Alert::success('Ура', 'Успешно добавлено');
                        return redirect()->back();
                    } else {

                        Event::create($request->all());

                        Alert::success('Ура', 'Успешно добавлено');
                        return redirect()->back();
                    }
                } else {

                    Event::where('id', $request->event_id)->update([
                        'title' => $request->title,
                        'start' => $request->start2_,
                        'end' => $request->end2,
                        'color' => $request->color,
                        'status' => $request->status,
                        'description' => $request->description,
                        'assigned' => $request->assigned,
                    ]);
                    Alert::success('Ура!', ' Запись обновлена');
                    return redirect()->back();
                }
            }
        } catch (Exception $e) {
            Alert::error("Ошибка", "Заполните поля корректно!");
            return redirect()->back();
        }
    }

    public function eventCheck($id)
    {
        $check_event = Event::where('id', $id)
            ->update(['readed' => 1]);
        if (!$check_event) {
            return response()->json([
                "status" => false
            ]);
        } else {
            return response()->json([
                "status" => true
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
    public function countTogle()
    {
        $togleInWokrs = Event::where('typeEvent', 'togle')
            ->count();
        $togleNotChecked = Event::where('typeEvent', 'togle')
            ->whereNull('readed')
            ->count();
        return response()->json([
            "togleInWokrs" => $togleInWokrs,
            "togleNotChecked" => $togleNotChecked,
        ]);
    }

    public function delete($id)
    {
        Event::destroy($id);
        return redirect()->back();
    }
}
