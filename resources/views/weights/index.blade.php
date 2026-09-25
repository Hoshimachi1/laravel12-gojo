<x-weight>
    <div class="row">
        <!-- ฝั่งซ้าย: ฟอร์มกรอกข้อมูล -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">บันทึกน้ำหนัก</h5>
                </div>
                <div class="card-body">
                    <!-- แสดงข้อความเมื่อบันทึกสำเร็จ -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('weights.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">น้ำหนัก (กก.)</label>
                            <input type="number" step="0.1" name="weight" class="form-control @error('weight') is-invalid @enderror" value="{{ old('weight') }}">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">วันที่บันทึก</label>
                            <input type="date" name="recorded_at" class="form-control @error('recorded_at') is-invalid @enderror" value="{{ old('recorded_at', date('Y-m-d')) }}">
                            @error('recorded_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">บันทึกข้อมูล</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ฝั่งขวา: แสดง Google Chart และ ตารางลบ/แก้ไข -->
        <div class="col-md-8">
            <!-- กราฟ Google Chart -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div id="curve_chart" style="width: 100%; height: 300px"></div>
                </div>
            </div>

            <!-- ตารางแสดงรายการน้ำหนัก -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>น้ำหนัก (กก.)</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->recorded_at }}</td>
                                <td>{{ $log->weight }}</td>
                                <td>
                                    <!-- ปุ่มแก้ไข (เปิด Modal) -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $log->id }}">แก้ไข</button>
                                    
                                    <!-- ปุ่มลบ -->
                                    <form action="{{ route('weights.destroy', $log->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('คุณต้องการลบข้อมูลนี้ใช่หรือไม่?')">ลบ</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal สำหรับแก้ไขข้อมูล -->
                            <div class="modal fade" id="editModal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('weights.update', $log->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">แก้ไขข้อมูลน้ำหนัก</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">น้ำหนัก (กก.)</label>
                                                    <input type="number" step="0.1" name="weight" class="form-control" value="{{ $log->weight }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">วันที่</label>
                                                    <input type="date" name="recorded_at" class="form-control" value="{{ $log->recorded_at }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" class="btn btn-primary">อัปเดตข้อมูล</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">ยังไม่มีข้อมูลน้ำหนัก</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- สคริปต์วาดกราฟ Google Chart -->
    @push('scripts')
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['วันที่', 'น้ำหนัก (กก.)'],
          @foreach($logs as $log)
            ['{{ $log->recorded_at }}', {{ $log->weight }}],
          @endforeach
        ]);

        var options = {
          title: 'ประวัติและแนวโน้มน้ำหนัก',
          curveType: 'function',
          legend: { position: 'bottom' },
          hAxis: { title: 'วันที่' },
          vAxis: { title: 'น้ำหนัก (กก.)' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
      }
    </script>
    @endpush
</x-weight>