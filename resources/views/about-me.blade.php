<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me - {{ $student['name'] }}</title>
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
        <!-- 1. ส่วนข้อมูลส่วนบุคคล (3 คะแนน) -->
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center py-4">
                <!-- รูปภาพ -->
                <img src="{{ $student['image'] }}" alt="Profile Image" class="profile-img mb-3 shadow-sm">
                
                <!-- ชื่อ - นามสกุล และ รหัสนักศึกษา -->
                <h2 class="fw-bold mb-1">{{ $student['name'] }}</h2>
                <p class="text-muted fs-5 mb-0">รหัสนักศึกษา: <strong>{{ $student['student_id'] }}</strong></p>
            </div>
        </div>

        <!-- 2. ลิงก์งานที่เคยทำ (3 คะแนน x 4 หัวข้อ) -->
        <h4 class="fw-bold mb-3 text-secondary">ผลงานที่เคยทำ</h4>
        <div class="row g-3">
            
            <!-- EP02 Hero -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-primary mb-1">EP02</span>
                            <h5 class="card-title fw-bold mb-0">EP02 Hero</h5>
                        </div>
                        <a href="{{ url('/gallery') }}" class="btn btn-outline-primary" target="_blank">
                            เปิดดูงาน /gallery
                        </a>
                    </div>
                </div>
            </div>

            <!-- EP03 Active Bootstrap -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-success mb-1">EP03</span>
                            <h5 class="card-title fw-bold mb-0">EP03 Active Bootstrap</h5>
                        </div>
                        <a href="{{ url('/active/index') }}" class="btn btn-outline-success" target="_blank">
                            เปิดดูงาน /active/index
                        </a>
                    </div>
                </div>
            </div>

            <!-- EP07 Weight -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-warning text-dark mb-1">EP07</span>
                            <h5 class="card-title fw-bold mb-0">EP07 Weight</h5>
                        </div>
                        <a href="{{ url('/weights') }}" class="btn btn-outline-warning text-dark" target="_blank">
                            เปิดดูงาน /weights
                        </a>
                    </div>
                </div>
            </div>

            <!-- EP08 Auth -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-danger mb-1">EP08</span>
                            <h5 class="card-title fw-bold mb-0">EP08 Auth</h5>
                        </div>
                        <a href="{{ url('/login') }}" class="btn btn-outline-danger" target="_blank">
                            ปุ่ม Login (/login)
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>