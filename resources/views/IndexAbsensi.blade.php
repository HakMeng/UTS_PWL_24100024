<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Mahasiswa</title>
    <!-- Include Bootstrap for easy styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding: 20px; }
        .table-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .status-label { margin-right: 15px; font-size: 0.9em; }
        .table thead th { background-color: #f1f3f5; border-bottom: 2px solid #dee2e6; }
        .text-hadir { color: #198754; font-weight: bold; }
        .text-sakit { color: #ffc107; font-weight: bold; }
        .text-izin { color: #0dcaf0; font-weight: bold; }
        .text-alpha { color: #dc3545; font-weight: bold; }
        .text-dash { color: #6c757d; }
    </style>
</head>
<body>

<div class="container table-container">
    <h4 class="mb-4">Form Absensi</h4>

    <!-- Filter Form -->
    <form action="{{ route('absensi.index') }}" method="GET" class="row mb-4 align-items-end">
        <div class="col-md-4">
            <label for="tanggal" class="form-label">Tanggal</label>
            <!-- Date Picker -->
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $selectedDate }}">
        </div>
        <div class="col-md-4">
            <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
            <!-- ComboBox (Dropdown) -->
            <select name="matakuliah_id" id="matakuliah_id" class="form-select" required>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach($matakuliahs as $mk)
                    <option value="{{ $mk->id }}" {{ $selectedMk == $mk->id ? 'selected' : '' }}>
                        {{ $mk->kode }} - {{ $mk->nama_matakuliah }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Only show the table if a Mata Kuliah is selected -->
    @if($selectedMk)
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
            <!-- Hidden inputs to pass the date and MK back to the controller -->
            <input type="hidden" name="tanggal_absensi" value="{{ $selectedDate }}">
            <input type="hidden" name="matakuliah_id" value="{{ $selectedMk }}">

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="35%">Mahasiswa</th>
                        <th width="20%">Keterangan</th>
                        <th width="40%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswas as $index => $mhs)
                        @php
                            // Check if this student has an existing record for the selected date/MK
                            $existingAbsen = $absensis->get($mhs->id);
                            $currentStatus = $existingAbsen ? $existingAbsen->status_absen : '';
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $mhs->name }}</strong><br>
                                <small class="text-muted">{{ $mhs->NIM }}</small>
                            </td>
                            <td>
                                <!-- Display colored text based on status (matching your image) -->
                                @if($currentStatus == 'Hadir')
                                    <span class="text-hadir">Hadir</span>
                                @elseif($currentStatus == 'Sakit')
                                    <span class="text-sakit">Sakit</span>
                                @elseif($currentStatus == 'Izin')
                                    <span class="text-izin">Izin</span>
                                @elseif($currentStatus == 'Alpa')
                                    <span class="text-alpha">Alpa</span>
                                @else
                                    <span class="text-dash">-</span>
                                @endif
                            </td>
                            <td>
                                <!-- Radio Buttons for each status -->
                                <label class="status-label">
                                    <input type="radio" name="status[{{ $mhs->id }}]" value="Hadir" {{ $currentStatus == 'Hadir' ? 'checked' : '' }}> H
                                </label>
                                <label class="status-label">
                                    <input type="radio" name="status[{{ $mhs->id }}]" value="Alpa" {{ $currentStatus == 'Alpa' ? 'checked' : '' }}> A
                                </label>
                                <label class="status-label">
                                    <input type="radio" name="status[{{ $mhs->id }}]" value="Izin" {{ $currentStatus == 'Izin' ? 'checked' : '' }}> I
                                </label>
                                <label class="status-label">
                                    <input type="radio" name="status[{{ $mhs->id }}]" value="Sakit" {{ $currentStatus == 'Sakit' ? 'checked' : '' }}> S
                                </label>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Simpan Absensi</button>
            </div>
        </form>
    @else
        <div class="alert alert-warning">Silakan pilih Tanggal dan Mata Kuliah terlebih dahulu.</div>
    @endif

</div>

</body>
</html>