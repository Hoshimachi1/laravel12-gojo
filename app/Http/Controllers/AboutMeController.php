<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutMeController extends Controller
{
    public function index()
    {
        // กำหนดข้อมูลส่วนบุคคล
        $student = [
            'name' => 'นายสมชาย ใจดี',           // เปลี่ยนเป็นชื่อของคุณ
            'student_id' => '65011234567',        // เปลี่ยนเป็นรหัสนักศึกษาของคุณ
            'image' => asset('images/profile.jpg'),// นำรูปไปวางที่ public/images/profile.jpg
        ];

        return view('about-me', compact('student'));
    }
}
