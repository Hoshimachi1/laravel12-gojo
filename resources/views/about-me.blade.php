<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me - {{ $student['name'] ?? 'ข้อมูลส่วนบุคคล' }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #0d6efd;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <!-- ข้อมูลส่วนบุคคล (3 คะแนน) -->
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center py-4">
                <img src="https://mail.google.com/mail/u/0/?ui=2&ik=8ad585d2f6&attid=0.3&permmsgid=msg-f:1875661555567615217&th=1a07b03f4276dcf1&view=fimg&disp=thd&attbid=ANGjdJ_IO9PuFiYR7OtcBFlcKr5XMk8gHHkq7aY_d9IusYkrLc0RkOjFP5MVgDOi6ycc_2Z_FclJgLG8WNXnEY2sTNHw-yDXUh4i6vMjDjwXmn59XWU80x2SFOT9fyk&ats=2524608000000&sz=w1366-h607&auditContext=prefetch" alt="Profile Image" class="profile-img mb-3 shadow-sm">
                <h2 class="fw-bold mb-1">{{ $student['name'] ?? 'ชื่อ-นามสกุล ของคุณ' }}</h2>
                <p class="text-muted fs-5 mb-0">รหัสนักศึกษา: <strong>{{ $student['student_id'] ?? 'รหัสนักศึกษา' }}</strong></p>
            </div>
        </div>

        <!-- รายการลิงก์ผลงาน (กดลิงก์จะเห็นงานทันที) -->
        <h4 class="fw-bold mb-3 text-secondary">ผลงานที่เคยทำ</h4>
        <div class="row g-3">

            <!-- EP02 Hero (3 คะแนน) -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-primary mb-1">EP02</span>
                            <h5 class="card-title fw-bold mb-0">EP02 Hero</h5>
                        </div>
                        <a href="{{ url('/gallery') }}" class="btn btn-outline-primary" target="_blank">
                            ดูงาน /gallery
                        </a>
                    </div>
                </div>
            </div>

            <!-- EP03 Active Bootstrap (3 คะแนน) -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-success mb-1">EP03</span>
                            <h5 class="card-title fw-bold mb-0">EP03 Active Bootstrap</h5>
                        </div>
                        <a href="{{ url('/active/index') }}" class="btn btn-outline-success" target="_blank">
                            ดูงาน /active/index
                        </a>
                    </div>
                </div>
            </div>

            <!-- EP07 Weight - ติด Auth (3 คะแนน) -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-warning text-dark mb-1">EP07 (Requires Auth)</span>
                            <h5 class="card-title fw-bold mb-0">EP07 Weight</h5>
                        </div>
                        <!-- เมื่อกด จะติดระบบ Auth หากยังไม่ลงชื่อเข้าใช้ระบบจะถูก Redirect ไปหน้า Login -->
                        <a href="{{ url('/weights') }}" class="btn btn-outline-warning text-dark" target="_blank">
                            ดูงาน /weights
                        </a>
                    </div>
                </div>
            </div>

            <!-- EP08 Auth - ปุ่ม Login (3 คะแนน) -->
            <!-- EP08 Auth - ปุ่ม Login -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-danger mb-1">EP08</span>
                            <h5 class="card-title fw-bold mb-0">EP08 Auth</h5>
                        </div>
                        <!-- ชี้ลิงก์ไปที่หน้าแรก / เพื่อเปิดหน้า welcome ตามรูป -->
                        <a href="{{ url('/') }}" class="btn btn-outline-danger" target="_blank">
                            ปุ่ม Login
                        </a>
                    </div>
                </div>
            </div>
</body>

</html>