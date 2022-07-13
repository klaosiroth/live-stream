<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ApiScheduleController extends Controller
{
    public function allMatch()
    {
        $data = Program::whereHas('schedule', function ($q) {
            return $q->whereDate('match_time', date('Y-m-d'));
        })
            ->with('schedule', function ($q) {
                return $q->select([
                    'id',
                    'program_id',
                    'home',
                    'away',
                    'match_time'
                ])
                    ->whereBetween('match_time', [
                        date('Y-m-d\T00:00'),
                        date('Y-m-d\T23:59')
                    ]);
            })
            ->get();
        return response()->json(['status' => 200, 'message' => 'OK', 'data' => $data]);
    }
    public function getMatch(Request $request)
    {
        $data = Schedule::whereHas('program')
            ->whereBetween('match_time', [
                date('Y-m-d\T00:00'),
                date('Y-m-d\T23:59')
            ])
            ->where('id', $request->id)->first();
        if (isset($data) && isset($data->program)) {
            $data->name = $data->program->name;
            unset($data->program);
            return response()->json(['status' => 200, 'message' => 'OK', 'data' => $data]);
        }
        return response()->json(['status' => 404, 'message' => 'Not found'], 404);
    }
}
