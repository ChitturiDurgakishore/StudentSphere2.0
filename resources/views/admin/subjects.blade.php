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
                    <a href="#" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Add New Subject
                    </a>
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
                                                    <th width="60%">Subject Name</th>
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
                                                        <td class="text-end">
                                                            <!-- Edit Button -->
                                                            <a href="#" class="btn btn-sm btn-primary me-2">
                                                                <i class="bi bi-pencil-square me-1"></i>Edit
                                                            </a>

                                                            <!-- Delete Button -->
                                                            <form method="POST" action="#" class="d-inline">
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
                                                        <td colspan="3" class="text-center py-4 text-muted">
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
            .table-hover tbody tr {
                transition: all 0.2s ease;
            }
            .table-hover tbody tr:hover {
                background-color: rgba(13, 110, 253, 0.05);
            }
            .btn-sm {
                padding: 0.35rem 0.65rem;
                font-size: 0.85rem;
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
