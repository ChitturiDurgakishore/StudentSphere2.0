<x-AdminUI :role="'admin'" :title="'Admin Panel'" :headerTitle="'Subjects Management'">
    <x-slot name="MainContent">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-book-half me-2"></i>Subjects Management</h5>
            </div>

            <div class="card-body p-4">
                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Add Subject Button -->
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-journal-bookmark me-2"></i>All Subjects</h4>
                    <!-- Button triggers modal -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                        <i class="bi bi-plus-circle me-1"></i>Add New Subject
                    </button>
                </div>

                <!-- Modal for Adding Subject -->
                <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.subjects.store') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addSubjectModalLabel">Add New Subject</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="subject_name" class="form-label">Subject Name</label>
                                        <input type="text" class="form-control" id="subject_name" name="subject_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Year</label>
                                        <select name="year" id="year" class="form-select" required>
                                            <option value="">Select Year</option>
                                            @for($i = 1; $i <= 4; $i++)
                                                <option value="{{ $i }}">Year {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="branch" class="form-label">Branch</label>
                                        <select name="branch" id="branch" class="form-select" required>
                                            <option value="">Select Branch</option>
                                            @php
                                                $branches = \App\Models\FileUpload::select('branch')->distinct()->pluck('branch');
                                            @endphp
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch }}">{{ $branch }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Add Subject</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @php
                    $years = ['1' => $one, '2' => $two, '3' => $three, '4' => $four];
                @endphp

                <!-- Tabs for Years -->
                <ul class="nav nav-tabs nav-justified mb-4" id="yearTabs" role="tablist">
                    @foreach ($years as $year => $subjects)
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
                    @foreach ($years as $year => $subjects)
                        <div class="tab-pane fade @if($loop->first) show active @endif" id="year-{{ $year }}" role="tabpanel">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="10%">ID</th>
                                                    <th width="40%">Subject Name</th>
                                                    <th width="20%">Branch</th>
                                                    <th width="30%" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subjects as $index => $subject)
                                                    <tr>
                                                        <td class="fw-medium">{{ $index + 1 }}</td>
                                                        <td>
                                                            <span class="d-block fw-medium">{{ $subject->subject_name }}</span>
                                                            <small class="text-muted">Subject Code: {{ $subject->subject_code ?? 'N/A' }}</small>
                                                        </td>
                                                        <td class="fw-medium">{{ $subject->branch ?? '-' }}</td>
                                                        <td class="text-end">
                                                            <!-- Edit Button triggers modal -->
                                                            <button type="button" class="btn btn-sm btn-primary me-2 edit-btn"
                                                                data-id="{{ $subject->id }}"
                                                                data-name="{{ $subject->subject_name }}"
                                                                data-year="{{ $subject->year }}"
                                                                data-branch="{{ $subject->branch }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editSubjectModal">
                                                                <i class="bi bi-pencil-square me-1"></i>Edit
                                                            </button>

                                                            <!-- Delete Button -->
                                                            <form method="POST" action="{{ route('admin.subjects.destroy', $subject->id) }}" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this subject?')">
                                                                    <i class="bi bi-trash me-1"></i>Delete
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if (count($subjects) == 0)
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4 text-muted">
                                                            <i class="bi bi-book-x fs-4 d-block mb-2"></i>
                                                            No subjects found for Year {{ $year }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" id="editSubjectForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_subject_name" class="form-label">Subject Name</label>
                                <input type="text" class="form-control" id="edit_subject_name" name="subject_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_year" class="form-label">Year</label>
                                <select name="year" id="edit_year" class="form-select" required>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}">Year {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_branch" class="form-label">Branch</label>
                                <select name="branch" id="edit_branch" class="form-select" required>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch }}">{{ $branch }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Subject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
            .nav-tabs .nav-link { color: #495057; border-bottom: 3px solid transparent; transition: all 0.2s ease; }
            .nav-tabs .nav-link:hover { border-bottom-color: #dee2e6; }
            .nav-tabs .nav-link.active { color: #0d6efd; border-bottom-color: #0d6efd; background-color: transparent; }
            .table-hover tbody tr { transition: all 0.2s ease; }
            .table-hover tbody tr:hover { background-color: rgba(13, 110, 253, 0.05); }
            .btn-sm { padding: 0.35rem 0.65rem; font-size: 0.85rem; }
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

            // Fill Edit Modal with selected subject
            const editButtons = document.querySelectorAll('.edit-btn');
            const editForm = document.getElementById('editSubjectForm');
            editButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    editForm.action = `/admin/subjects/${btn.dataset.id}`;
                    document.getElementById('edit_subject_name').value = btn.dataset.name;
                    document.getElementById('edit_year').value = btn.dataset.year;
                    document.getElementById('edit_branch').value = btn.dataset.branch;
                });
            });
        </script>
    </x-slot>
</x-AdminUI>
