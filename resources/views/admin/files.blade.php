<x-AdminUI :role="'admin'" :title="'Admin Panel'" :headerTitle="'Uploaded Files'">
    <x-slot name="MainContent">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-folder-fill me-2"></i>Uploaded Files</h5>
            </div>

            <div class="card-body p-4">
                <!-- Tabs for Years -->
                <ul class="nav nav-tabs nav-justified mb-4" id="yearTabs" role="tablist">
                    @foreach([1,2,3,4] as $year)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if($loop->first) active @endif fw-medium"
                                id="year-{{ $year }}-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#year-{{ $year }}"
                                type="button"
                                role="tab">
                                <i class="bi bi-{{ $year }}-square me-1"></i> Year {{ $year }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content" id="yearTabsContent">
                    @foreach([1=>'one',2=>'two',3=>'three',4=>'four'] as $year=>$var)
                        @php $files = $$var; @endphp
                        <div class="tab-pane fade @if($loop->first) show active @endif" id="year-{{ $year }}" role="tabpanel">
                            @if($files->isEmpty())
                                <div class="alert alert-info text-center py-4">
                                    <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
                                    No files uploaded for Year {{ $year }}
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="40px">#</th>
                                                <th>Subject</th>
                                                <th>Type</th>
                                                <th>Unit</th>
                                                <th>Uploaded By</th>
                                                <th>Date</th>
                                                <th width="120px">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($files as $index => $file)
                                                <tr>
                                                    <td class="fw-medium text-muted">{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-medium">{{ $file->subject->subject_name ?? 'N/A' }}</span>
                                                            <small class="text-muted text-truncate" style="max-width: 200px;">
                                                                {{ $file->description ?? 'No description' }}
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $file->file_type == 'notes' ? 'info' : 'warning' }} text-dark">
                                                            {{ strtoupper($file->file_type) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($file->unit)
                                                            <span class="badge bg-secondary">UNIT {{ $file->unit }}</span>
                                                        @else
                                                            <span class="badge bg-success">LAB</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span>{{ $file->uploader_name }}</span>
                                                            <small class="text-muted">{{ $file->branch }}</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">

                                                            <small class="text-muted">{{ $file->uploaded_at}}</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ $file->file_link }}" target="_blank" class="btn btn-sm btn-outline-primary" title="View">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <form action="{{ route('admin.deleteFileDb', $file->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('Delete this file?')"
                                                                    title="Delete">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
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
        </div>

        <style>
            .nav-tabs .nav-link {
                color: #495057;
                border-bottom: 3px solid transparent;
                transition: all 0.2s ease;
            }
            .nav-tabs .nav-link:hover {
                border-bottom-color: #dee2e6;
            }
            .nav-tabs .nav-link.active {
                color: #0d6efd;
                border-bottom-color: #0d6efd;
                background-color: transparent;
            }
            .table {
                border-collapse: separate;
                border-spacing: 0 10px;
            }
            .table-hover tbody tr {
                transition: all 0.2s ease;
                background-color: white;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }
            .table-hover tbody tr:hover {
                box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            }
            .table td {
                padding: 12px 15px;
                vertical-align: middle;
            }
            .table th {
                padding: 12px 15px;
                background-color: #f8f9fa;
                border: none;
            }
            .badge {
                font-weight: 500;
                padding: 5px 8px;
            }
            .text-truncate {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                display: inline-block;
                max-width: 100%;
            }
        </style>

        <script>
            // Initialize Bootstrap tabs
            var tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
            tabEls.forEach(function(tabEl) {
                tabEl.addEventListener('shown.bs.tab', function (event) {
                    event.target // newly activated tab
                    event.relatedTarget // previous active tab
                });
            });
        </script>
    </x-slot>
</x-AdminUI>
