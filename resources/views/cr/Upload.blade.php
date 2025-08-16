<x-CRUI :role="'cr'" :title="'CR Panel'" :headerTitle="'Upload Files'">
    <x-slot name="MainContent">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center"><i class="bi bi-cloud-arrow-up-fill me-2"></i>Upload New File</h4>
            </div>

            <div class="card-body p-4">
                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Upload Form -->
                <form method="POST" action="{{ route('cr.UploadFile') }}" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                    @csrf

                    <div class="col-md-6">
                        <label for="subject_id" class="form-label fw-bold">Subject</label>
                        <select name="subject_id" id="subject_id" class="form-select shadow-sm" required>
                            <option value="" selected disabled>Select a subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select a subject.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="file_type" class="form-label fw-bold">File Type</label>
                        <select name="file_type" id="file_type" class="form-select shadow-sm" required>
                            <option value="" selected disabled>Select file type</option>
                            @foreach ($fileTypes as $type)
                                <option value="{{ $type->id }}">{{ strtoupper($type->file_type) }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please select a file type.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="unit" class="form-label fw-bold">Unit</label>
                        <select name="unit" id="unit" class="form-select shadow-sm" required>
                            <option value="" selected disabled>Select unit</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">UNIT {{ $i }}</option>
                            @endfor
                            <option value="">Lab</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a unit.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="description" class="form-label fw-bold">Description <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="description" id="description" class="form-control shadow-sm" placeholder="Enter file description">
                    </div>

                    <div class="col-12">
                        <label for="file" class="form-label fw-bold">Choose File</label>
                        <div class="input-group">
                            <input type="file" name="file" id="file" class="form-control shadow-sm" accept=".pdf,.docx,.jpg,.png,.jpeg" required>
                            <button class="btn btn-outline-secondary" type="button" id="file-clear">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="form-text">Allowed formats: PDF, DOCX, JPG, PNG, JPEG</div>
                        <div class="invalid-feedback">
                            Please select a file to upload.
                        </div>
                    </div>

                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold">
                            <i class="bi bi-upload me-2"></i>Upload File
                        </button>
                    </div>
                </form>

                @if (!session('google_access_token'))
                    <div class="text-center mt-5 pt-3 border-top">
                        <a href="{{ route('google.login') }}" class="btn btn-outline-primary px-4">
                            <i class="bi bi-google me-2"></i>Connect to Google Drive
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <style>
            .form-control:focus, .form-select:focus {
                border-color: #86b7fe;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            }
            .card {
                border-radius: 10px;
                overflow: hidden;
            }
            .card-header {
                border-radius: 0 !important;
            }
            .btn-success {
                transition: all 0.3s ease;
            }
            .btn-success:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
        </style>

        <script>
            // Clear file input
            document.getElementById('file-clear').addEventListener('click', function() {
                document.getElementById('file').value = '';
            });

            // Form validation
            (function() {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')

                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>
    </x-slot>
</x-CRUI>
