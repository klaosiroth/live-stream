<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Schedule;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $program = Program::get();
        $from = date('Y-m-d\T00:00', strtotime($request->from ?? date('Y-m-d H:i:s')));
        $to = date('Y-m-d\T23:59', strtotime($request->to ?? date('Y-m-d H:i:s')));
        if (isset($request->programId)) {
            $data = Schedule::whereBetween('match_time', [$from, $to])->where(['program_id' => $request->programId])->get();
        } else {
            $data = Schedule::whereBetween('match_time', [$from, $to])->get();
        }
        return view('schedule.index', compact(['data', 'program', 'request']));
    }

    public function addSchedule()
    {
        $program = Program::get();
        return view('schedule.add', compact(['program']));
    }

    public function postSchedule(Request $request)
    {
        if ($this->isMatchExists($request)) {
            Alert::warning('ข้อมูลมีอยู่แล้วในระบบ');
            return redirect()->back()->withInput();
        }
        $created = Schedule::create([
            'program_id' => $request->programId,
            'home' => $request->home,
            'away' => $request->away,
            'match_time' => $request->match_time,
            'youtube' => $request->youtube ?? null,
            'facebook' => $request->facebook ?? null,
        ]);

        if (!isset($created)) {
            Alert::error('ไม่สามาเพิ่มข้อมูลได้ชั่วคราว');
            return redirect()->back()->withInput();
        } else {
            Alert::success('เพิ่มข้อมูลสำเร็จ');
        }
        if ($request->more == 'on') {
            return redirect()->back()->withInput(['programId', 'match_time']);
        }
        return redirect('/schedule');
    }

    public function editSchedule(Request $request)
    {
        $program = Program::get();
        $data = Schedule::find($request->id);
        return view('schedule.edit', compact(['data', 'program']));
    }

    public function updateSchedule(Request $request)
    {
        if ($this->isMatchExists($request)) {
            Alert::warning('ข้อมูลมีอยู่แล้วในระบบ');
            return redirect()->back()->withInput();
        }
        $data = Schedule::find($request->id);
        $data->update([
            'program_id' => $request->programId,
            'home' => $request->home,
            'away' => $request->away,
            'match_time' => $request->match_time,
            'youtube' => $request->youtube ?? null,
            'facebook' => $request->facebook ?? null,
        ]);
        if ($data) {
            Alert::success('แก้ไขข้อมูลแล้ว');
            return redirect('/schedule');
        } else {
            Alert::error('ไม่สามารถแก้ไขข้อมูลได้ชั่วคราว');
            return redirect()->back()->withInput();;
        }
    }

    public function deleteSchedule(Request $request)
    {
        $data = Schedule::find($request->id);
        if ($data->delete()) {
            Alert::success('ลบข้อมูลสำเร็จ');
        } else {
            Alert::error('ไม่สามารถลบข้อมูลได้ชั่วคราว');
        }
        return redirect()->back();
    }

    private function isMatchExists($request)
    {
        $exists = Schedule::firstWhere([
            'home' => $request->home,
            'away' => $request->away,
            'match_time' => $request->match_time,
            'youtube' => $request->youtube,
            'facebook' => $request->facebook,
        ]);
        return isset($exists);
    }
}
