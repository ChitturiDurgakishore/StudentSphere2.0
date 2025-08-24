{{-- resources/views/student/materials.blade.php --}}
<x-CRUI :role="'cr'" :title="'CR Panel'" :headerTitle="'Available Materials'">
    <x-slot name="MainContent">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Show current branch & year --}}
        <div class="mb-3">
            <strong>Branch:</strong> {{ session('branch') ?? 'N/A' }} &nbsp; | &nbsp;
            <strong>Year:</strong> {{ session('year') ?? 'N/A' }}
        </div>

        {{-- Filter Form --}}
        <div class="card shadow-sm p-4 mb-4">
            <h4 class="mb-4 text-center">📂 Filter Materials</h4>

            <form method="GET" action="{{ route('cr.Materials') }}" class="row g-3">
                <div class="col-md-4">
                    <select name="subject_id" class="form-select">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" @if(request('subject_id') == $subject->id) selected @endif>
                                {{ $subject->subject_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <select name="file_type_id" class="form-select">
                        <option value="">-- Select File Type --</option>
                        @foreach($fileTypes as $type)
                            <option value="{{ $type->id }}" @if(request('file_type_id') == $type->id) selected @endif>
                                {{ strtoupper($type->file_type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="unit" class="form-select">
                        <option value="">-- Select Unit --</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" @if(request('unit') == $i) selected @endif>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>

        {{-- Materials Table --}}
        <div class="card shadow-sm p-4">
            <h4 class="mb-4 text-center">📂 Materials for Your Branch & Year</h4>

            @if($files->isEmpty())
                <div class="alert alert-info text-center">
                    No materials available at the moment.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>File Type</th>
                                <th>Unit</th>
                                <th>Uploaded By</th>
                                <th>Link</th>
                                <th>Uploaded At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $index => $file)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $file->subject_name ?? 'N/A' }}</td>
                                    <td>{{ $file->description ?? '-' }}</td>
                                    <td>{{ strtoupper($file->file_type_name ?? 'N/A') }}</td>
                                    <td>{{ $file->unit }}</td>
                                    <td>{{ $file->uploader_name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ $file->file_link }}" target="_blank" class="btn btn-sm btn-primary">
                                            View
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

    </x-slot>
</x-studentUI>
