<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use Illuminate\Http\Request;

class WeightLogController extends Controller
{
    public function index()
    {
        $logs = WeightLog::orderBy('recorded_at', 'asc')->get();
        return view('weight_logs.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|between:20,300',
            'recorded_at' => 'required|date|before_or_equal:today',
            'note' => 'nullable|string|max:255',
        ], [
            'weight.required' => 'กรุณากรอกน้ำหนัก',
            'weight.between' => 'น้ำหนักต้องอยู่ระหว่าง 20 - 300 กก.',
            'recorded_at.required' => 'กรุณาเลือกวันที่บันทึก',
            'recorded_at.before_or_equal' => 'วันที่บันทึกต้องไม่เป็นวันในอนาคต',
        ]);

        WeightLog::create($validated);
        return back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function update(Request $request, WeightLog $weightLog)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|between:20,300',
            'recorded_at' => 'required|date|before_or_equal:today',
            'note' => 'nullable|string|max:255',
        ]);

        $weightLog->update($validated);
        return back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }

    public function destroy(WeightLog $weightLog)
    {
        $weightLog->delete();
        return back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}