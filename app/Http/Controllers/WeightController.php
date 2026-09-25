<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    public function index()
    {
        $logs = WeightLog::orderBy('recorded_at', 'asc')->get();
        return view('weights.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|min:1|max:500',
            'recorded_at' => 'required|date',
        ]);

        WeightLog::create($validated);
        return back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function update(Request $request, WeightLog $weight)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|min:1|max:500',
            'recorded_at' => 'required|date',
        ]);

        $weight->update($validated);
        return back()->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }

    public function destroy(WeightLog $weight)
    {
        $weight->delete();
        return back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }

}