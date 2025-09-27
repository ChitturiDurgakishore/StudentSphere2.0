{{-- resources/views/student/materials.blade.php --}}
<x-studentUI :role="'student'" :title="'Student Panel'" :headerTitle="'Available Materials'">
    <x-slot name="MainContent">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Branch & Year --}}
        <div class="mb-4 text-center">
            <span class="badge bg-primary mx-2 px-3 py-2">Branch: {{ session('branch') ?? 'N/A' }}</span>
            <span class="badge bg-secondary mx-2 px-3 py-2">Year: {{ session('year') ?? 'N/A' }}</span>
        </div>

        {{-- Filter Form --}}
        <div class="mb-5">
            <form method="GET" action="{{ route('student.Materials') }}" class="row g-3 justify-content-center">
                <div class="col-md-3">
                    <select name="subject_id" class="form-select rounded-pill py-2">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" @if(request('subject_id') == $subject->id) selected @endif>
                                {{ $subject->subject_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="file_type_id" class="form-select rounded-pill py-2">
                        <option value="">-- File Type --</option>
                        @foreach($fileTypes as $type)
                            <option value="{{ $type->id }}" @if(request('file_type_id') == $type->id) selected @endif>
                                {{ strtoupper($type->file_type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="unit" class="form-select rounded-pill py-2">
                        <option value="">-- Unit --</option>
                        @for($i=1;$i<=5;$i++)
                            <option value="{{ $i }}" @if(request('unit')==$i) selected @endif>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary rounded-pill py-2">Filter</button>
                </div>
            </form>
        </div>

        {{-- Materials Table --}}
        <div>
            @if($files->isEmpty())
                <div class="alert alert-info text-center py-4">
                    No materials available at the moment.
                </div>
            @else
                <div class="table-responsive" style="max-height: 60vh; overflow-y:auto;">
                    <table class="table align-middle text-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Unit</th>
                                <th>Uploader</th>
                                <th>Link</th>
                                <th>Uploaded</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $index=>$file)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $file->subject_name ?? 'N/A' }}</td>
                                    <td class="text-start">{{ $file->description ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark px-2">{{ strtoupper($file->file_type_name ?? 'N/A') }}</span>
                                    </td>
                                    <td>
                                        @if($file->unit)
                                            <span class="badge bg-secondary px-2">Unit {{ $file->unit }}</span>
                                        @else
                                            <span class="badge bg-success px-2">LAB</span>
                                        @endif
                                    </td>
                                    <td>{{ $file->uploader_name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ $file->file_link }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill">
                                            View </i>
                                        </a>
                                    </td>
                                    <td>{{ $file->uploaded_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <style>
            /* Minimal elegant styling */
            table thead th {
                font-weight: 600;
                text-transform: uppercase;
            }
            table tbody tr:hover {
                background-color: rgba(67, 97, 238, 0.08);
                transition: 0.2s;
            }
            .form-select:focus {
                box-shadow: 0 0 8px rgba(67,97,238,0.3);
                border-color: #4361ee;
            }
            .btn-outline-primary:hover {
                background-color: #4361ee;
                color: #fff;
            }
        </style>

    </x-slot>
</x-studentUI>
