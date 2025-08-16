<x-admin-ui :role="'admin'" :title="'Admin Panel'" :headerTitle="'User Management'">
    <x-slot name="MainContent">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>User Management</h5>
            </div>

            <div class="card-body p-4">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                    <!-- YEAR 1 -->
                    <div class="tab-pane fade show active" id="year-1" role="tabpanel">
                        <div class="mb-4">
                            <h5 class="d-flex align-items-center mb-3">
                                <span class="badge bg-success me-2">Students</span>
                                <span class="text-muted fs-6">(Year 1)</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Name</th>
                                            <th width="25%">Email</th>
                                            <th width="10%">Roll No</th>
                                            <th width="20%">Branch</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($OneStudents as $i => $student)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td class="fw-medium">{{ $student->name }}</td>
                                                <td><small class="text-muted">{{ $student->email }}</small></td>
                                                <td>{{ $student->rollno }}</td>
                                                <td>{{ $student->branch }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.promote-student', $student->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Promote this student to CR?')">
                                                            <i class="bi bi-arrow-up-circle me-1"></i>Promote
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="bi bi-people-slash fs-4 d-block mb-2"></i>
                                                    No students found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <h5 class="d-flex align-items-center mb-3">
                                <span class="badge bg-info me-2">Class Representatives</span>
                                <span class="text-muted fs-6">(Year 1)</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Name</th>
                                            <th width="25%">Email</th>
                                            <th width="10%">Roll No</th>
                                            <th width="20%">Branch</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($OneCrs as $i => $cr)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td class="fw-medium">{{ $cr->name }}</td>
                                                <td><small class="text-muted">{{ $cr->email }}</small></td>
                                                <td>{{ $cr->rollno }}</td>
                                                <td>{{ $cr->branch }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.demote-cr', $cr->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Demote this CR to student?')">
                                                            <i class="bi bi-arrow-down-circle me-1"></i>Demote
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                                    No CRs found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- YEAR 2 -->
                    <div class="tab-pane fade" id="year-2" role="tabpanel">
                        <div class="mb-4">
                            <h5 class="d-flex align-items-center mb-3">
                                <span class="badge bg-success me-2">Students</span>
                                <span class="text-muted fs-6">(Year 2)</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Name</th>
                                            <th width="25%">Email</th>
                                            <th width="10%">Roll No</th>
                                            <th width="20%">Branch</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($TwoStudents as $i => $student)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td class="fw-medium">{{ $student->name }}</td>
                                                <td><small class="text-muted">{{ $student->email }}</small></td>
                                                <td>{{ $student->rollno }}</td>
                                                <td>{{ $student->branch }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.promote-student', $student->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Promote this student to CR?')">
                                                            <i class="bi bi-arrow-up-circle me-1"></i>Promote
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="bi bi-people-slash fs-4 d-block mb-2"></i>
                                                    No students found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <h5 class="d-flex align-items-center mb-3">
                                <span class="badge bg-info me-2">Class Representatives</span>
                                <span class="text-muted fs-6">(Year 2)</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Name</th>
                                            <th width="25%">Email</th>
                                            <th width="10%">Roll No</th>
                                            <th width="20%">Branch</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($TwoCrs as $i => $cr)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td class="fw-medium">{{ $cr->name }}</td>
                                                <td><small class="text-muted">{{ $cr->email }}</small></td>
                                                <td>{{ $cr->rollno }}</td>
                                                <td>{{ $cr->branch }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.demote-cr', $cr->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Demote this CR to student?')">
                                                            <i class="bi bi-arrow-down-circle me-1"></i>Demote
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                                    No CRs found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- YEAR 3 -->
                    <div class="tab-pane fade" id="year-3" role="tabpanel">
                        <div class="mb-4">
                            <h5 class="d-flex align-items-center mb-3">
                                <span class="badge bg-success me-2">Students</span>
                                <span class="text-muted fs-6">(Year 3)</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Name</th>
                                            <th width="25%">Email</th>
                                            <th width="10%">Roll No</th>
                                            <th width="20%">Branch</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($ThreeStudents as $i => $student)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td class="fw-medium">{{ $student->name }}</td>
                                                <td><small class="text-muted">{{ $student->email }}</small></td>
                                                <td>{{ $student->rollno }}</td>
                                                <td>{{ $student->branch }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.promote-student', $student->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Promote this student to CR?')">
                                                            <i class="bi bi-arrow-up-circle me-1"></i>Promote
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="bi bi-people-slash fs-4 d-block mb-2"></i>
                                                    No students found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <h5 class="d-flex align-items-center mb-3">
                                <span class="badge bg-info me-2">Class Representatives</span>
                                <span class="text-muted fs-6">(Year 3)</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Name</th>
                                            <th width="25%">Email</th>
                                            <th width="10%">Roll No</th>
                                            <th width="20%">Branch</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($ThreeCrs as $i => $cr)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td class="fw-medium">{{ $cr->name }}</td>
                                                <td><small class="text-muted">{{ $cr->email }}</small></td>
                                                <td>{{ $cr->rollno }}</td>
                                                <td>{{ $cr->branch }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.demote-cr', $cr->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Demote this CR to student?')">
                                                            <i class="bi bi-arrow-down-circle me-1"></i>Demote
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                                    No CRs found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- YEAR 4 -->
                    <div class="tab-pane fade" id="year-4" role="tabpanel">
                        <div class="mb-4">
                            <h5 class="d-flex align-items-center mb-3">
                                <span class="badge bg-success me-2">Students</span>
                                <span class="text-muted fs-6">(Year 4)</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Name</th>
                                            <th width="25%">Email</th>
                                            <th width="10%">Roll No</th>
                                            <th width="20%">Branch</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($FourStudents as $i => $student)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td class="fw-medium">{{ $student->name }}</td>
                                                <td><small class="text-muted">{{ $student->email }}</small></td>
                                                <td>{{ $student->rollno }}</td>
                                                <td>{{ $student->branch }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.promote-student', $student->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Promote this student to CR?')">
                                                            <i class="bi bi-arrow-up-circle me-1"></i>Promote
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="bi bi-people-slash fs-4 d-block mb-2"></i>
                                                    No students found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <h5 class="d-flex align-items-center mb-3">
                                <span class="badge bg-info me-2">Class Representatives</span>
                                <span class="text-muted fs-6">(Year 4)</span>
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Name</th>
                                            <th width="25%">Email</th>
                                            <th width="10%">Roll No</th>
                                            <th width="20%">Branch</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($FourCrs as $i => $cr)
                                            <tr>
                                                <td>{{ $i+1 }}</td>
                                                <td class="fw-medium">{{ $cr->name }}</td>
                                                <td><small class="text-muted">{{ $cr->email }}</small></td>
                                                <td>{{ $cr->rollno }}</td>
                                                <td>{{ $cr->branch }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('admin.demote-cr', $cr->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Demote this CR to student?')">
                                                            <i class="bi bi-arrow-down-circle me-1"></i>Demote
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                                    No CRs found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
            }
        </style>
    </x-slot>
</x-admin-ui>
