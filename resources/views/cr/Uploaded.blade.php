{{-- resources/views/cr/Uploaded.blade.php --}}
<x-CRUI :headerTitle="'My Uploaded Files'">
    <x-slot name="MainContent">
        <div class="container mt-4">
            <h3 class="mb-4 text-center">📂 My Uploaded Files</h3>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($subjects->isEmpty())
                <div class="alert alert-info text-center">
                    No files uploaded yet 🚫
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
                                <th>Year</th>
                                <th>Branch</th>
                                <th>Link</th>
                                <th>Uploaded At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $index => $file)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $file->subject->subject_name ?? 'N/A' }}</td>
                                    <td>{{ $file->description ?? '-' }}</td>
                                    <td>{{ strtoupper($file->file_type) }}</td>
                                    <td>{{ $file->unit }}</td>
                                    <td>{{ $file->year }}</td>
                                    <td>{{ $file->branch }}</td>
                                    <td>
                                        <a href="{{ $file->file_link }}" target="_blank" class="btn btn-sm btn-primary">
                                            View File
                                        </a>
                                    </td>
                                    <td>{{ $file->created_at }}</td>
                                    <td>
                                        {{-- Delete --}}
                                        <form action="{{ route('cr.deleteFile', $file->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this file?');">
                                                Delete
                                            </button>
                                        </form>

                                        {{-- Replace --}}
                                        <form class="replace-form" action="{{ route('cr.replaceFile', $file->id) }}" method="POST" enctype="multipart/form-data" style="display:inline;">
                                            @csrf
                                            <input type="file" name="file" class="replace-input" style="display:none;">
                                            <button type="button" class="btn btn-sm btn-warning replace-btn">Replace</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- JS for seamless replace --}}
        <script>
            document.querySelectorAll('.replace-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('.replace-form');
                    const input = form.querySelector('.replace-input');
                    input.click();
                    input.addEventListener('change', function() {
                        if(this.files.length > 0) {
                            form.submit(); // auto-submit once file selected
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-CRUI>
