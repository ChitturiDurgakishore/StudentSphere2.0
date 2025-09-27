<x-studentUI :role="'student'" :title="'Student Panel'" :headerTitle="'Previous Year Files'">
    <x-slot name="MainContent">

        {{-- Filter Form --}}
        <div class="card shadow-sm rounded-4 border-0 mb-4 p-4">
            <h4 class="text-center mb-4 text-primary fw-bold"><i class="bi bi-folder-fill me-2"></i>Filter Previous Year Files</h4>
            <form method="GET" action="{{ route('student.PreviousMaterials') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <select name="subject_id" class="form-select rounded-pill">
                        <option value="">All Subjects</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @if(request('subject_id') == $subject->id) selected @endif>
                                {{ $subject->subject_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <select name="branch" class="form-select rounded-pill">
                        <option value="">All Branches</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch }}" @if(request('branch') == $branch) selected @endif>
                                {{ $branch }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <select name="file_type_id" class="form-select rounded-pill">
                        <option value="">All File Types</option>
                        @foreach ($filetypes as $type)
                            <option value="{{ $type->id }}" @if(request('file_type_id') == $type->id) selected @endif>
                                {{ $type->file_type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary rounded-pill"><i class="bi bi-search me-1"></i> Search</button>
                </div>
            </form>
        </div>

        {{-- Tabs & Files --}}
        <div class="card shadow-sm rounded-4 border-0 p-4">
            <ul class="nav nav-tabs nav-justified mb-4" id="yearTabs" role="tablist">
                @foreach ([1,2,3,4] as $year)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($loop->first) active @endif fw-medium"
                            id="year-{{ $year }}-tab" data-bs-toggle="tab"
                            data-bs-target="#year-{{ $year }}" type="button" role="tab">
                            Year {{ $year }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="yearTabsContent">
                @foreach ([1=>'one',2=>'two',3=>'three',4=>'four'] as $year => $var)
                    @php $files = $$var; @endphp
                    <div class="tab-pane fade @if($loop->first) show active @endif" id="year-{{ $year }}" role="tabpanel">
                        @if($files->isEmpty())
                            <div class="alert alert-info text-center py-4">
                                <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
                                No files uploaded for Year {{ $year }}
                            </div>
                        @else
                            <div class="table-responsive" style="max-height:60vh; overflow-y:auto;">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th>#</th>
                                            <th>Subject</th>
                                            <th>Branch</th>
                                            <th>Type</th>
                                            <th>Unit</th>
                                            <th>Uploaded By</th>
                                            <th>Date</th>
                                            <th>View File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($files as $index => $file)
                                            <tr class="align-middle text-center">
                                                <td class="fw-medium text-muted">{{ $index+1 }}</td>
                                                <td class="text-start">
                                                    <span class="fw-medium">{{ $file->subject->subject_name ?? 'N/A' }}</span>
                                                    <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                                        {{ $file->description ?? 'No description' }}
                                                    </small>
                                                </td>
                                                <td>{{ $file->branch }}</td>
                                                <td>
                                                    <span class="badge rounded-pill bg-{{ $file->file_type == 'notes' ? 'info' : 'warning' }} text-dark">
                                                        {{ strtoupper($file->file_type_name ?? 'N/A') }}

                                                    </span>
                                                </td>
                                                <td>
                                                    @if($file->unit)
                                                        <span class="badge rounded-pill bg-secondary">UNIT {{ $file->unit }}</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-success">LAB</span>
                                                    @endif
                                                </td>
                                                <td>{{ $file->uploader_name }}</td>
                                                <td><small class="text-muted">{{ $file->uploaded_at }}</small></td>
                                                <td>
                                                    <a href="{{ $file->file_link }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                                         View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <style>
            .nav-tabs .nav-link {
                border: none;
                border-bottom: 3px solid transparent;
                color: #495057;
                transition: all 0.2s ease;
            }
            .nav-tabs .nav-link.active {
                color: #0d6efd;
                border-bottom-color: #0d6efd;
                background-color: transparent;
            }
            .table-hover tbody tr {
                transition: all 0.2s ease;
                background-color: white;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                border-radius: 8px;
                margin-bottom: 5px;
            }
            .table-hover tbody tr:hover {
                box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            }
            .table th, .table td { vertical-align: middle; }
            .table th { background-color: #f8f9fa; }
            .badge { font-weight: 500; padding: 5px 10px; }
            .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        </style>

    </x-slot>
</x-studentUI>
