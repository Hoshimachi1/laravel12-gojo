<x-weight>
    <x-slot:title>ติดตามน้ำหนักร่างกาย</x-slot:title>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white font-weight-bold">บันทึกน้ำหนัก</div>
                <div class="card-body">
                    <form action="{{ route('weight-logs.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">น้ำหนัก (กิโลกรัม)</label>
                            <input type="number" step="0.1" name="weight" value="{{ old('weight') }}" class="form-control @error('weight') is-invalid @enderror">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">วันที่บันทึก</label>
                            <input type="date" name="recorded_at" value="{{ old('recorded_at', date('Y-m-d')) }}" class="form-control @error('recorded_at') is-invalid @enderror">
                            @error('recorded_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">หมายเหตุ</label>
                            <input type="text" name="note" value="{{ old('note') }}" class="form-control @error('note') is-invalid @enderror">
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">บันทึกข้อมูล</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div id="curve_chart" style="width: 100%; height: 300px"></div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>วันที่</th>
                                <th>น้ำหนัก (กิโลกรัม)</th>
                                <th>หมายเหตุ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($log->recorded_at)->format('d/m/Y') }}</td>
                                    <td><strong>{{ $log->weight }}</strong></td>
                                    <td>{{ $log->note ?? '-' }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $log->id }}">แก้ไข</button>

                                        <form action="{{ route('weight-logs.destroy', $log->id) }}" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการลบข้อมูล?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">ลบ</button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editModal{{ $log->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('weight-logs.update', $log->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">แก้ไขข้อมูลน้ำหนัก</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">น้ำหนัก (กิโลกรัม)</label>
                                                        <input type="number" step="0.1" name="weight" value="{{ $log->weight }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">วันที่บันทึก</label>
                                                        <input type="date" name="recorded_at" value="{{ $log->recorded_at }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">หมายเหตุ</label>
                                                        <input type="text" name="note" value="{{ $log->note }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">ยังไม่มีข้อมูลน้ำหนัก</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['วันที่', 'น้ำหนัก (กก.)'],
                    @foreach($logs as $log)
                        ['{{ \Carbon\Carbon::parse($log->recorded_at)->format("d/m") }}', {{ $log->weight }}],
                    @endforeach
                ]);

                var options = {
                    title: 'แนวโน้มน้ำหนักร่างกาย',
                    curveType: 'function',
                    legend: { position: 'bottom' },
                    colors: ['#0d6efd'],
                    chartArea: { width: '85%', height: '70%' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                chart.draw(data, options);
            }
        </script>
    </x-slot:scripts>
</x-weight>