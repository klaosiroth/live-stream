<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProgramController extends Controller
{
    public function index()
    {
        $data = Program::get();
        return view('program.index', compact(['data']));
    }

    public function addProgram()
    {
        return view('program.add');
    }

    public function postProgram(Request $request)
    {
        if ($this->isNameExists($request->name)) {
            Alert::warning('ข้อมูลมีอยู่แล้วในระบบ');
            return redirect()->back()->withInput();
        }
        $created = Program::create(['name' => $request->name]);

        if (!isset($created)) {
            Alert::error('ไม่สามาเพิ่มข้อมูลได้ชั่วคราว');
            return redirect()->back()->withInput();
        } else {
            Alert::success('เพิ่มข้อมูลสำเร็จ');
        }
        if ($request->more == 'on') {
            return redirect()->back()->withInput();
        }
        return redirect('/program');
    }

    public function editProgram(Request $request)
    {
        $data = Program::find($request->id);
        return view('program.edit', compact(['data']));
    }

    public function updateProgram(Request $request)
    {
        if ($this->isNameExists($request->name)) {
            Alert::warning('ข้อมูลมีอยู่แล้วในระบบ');
            return redirect()->back()->withInput();
        }
        $data = Program::find($request->id);
        $data->name = $request->name;
        if ($data->save()) {
            Alert::success('แก้ไขข้อมูลแล้ว');
            return redirect('/program');
        } else {
            Alert::error('ไม่สามารถแก้ไขข้อมูลได้ชั่วคราว');
            return redirect()->back()->withInput();;
        }
    }

    public function deleteProgram(Request $request)
    {
        $data = Program::find($request->id);
        if ($data->delete()) {
            Alert::success('ลบข้อมูลสำเร็จ');
        } else {
            Alert::error('ไม่สามารถลบข้อมูลได้ชั่วคราว');
        }
        return redirect()->back();
    }

    private function isNameExists($name)
    {
        $exists = Program::firstWhere(['name' => $name]);
        return isset($exists);
    }
}
