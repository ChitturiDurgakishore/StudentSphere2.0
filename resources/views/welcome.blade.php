<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentSphere - Registration</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #dfe9f3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .registration-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: none;
            background: white;
            padding: 2rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 10px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-1px);
            transition: all 0.3s ease;
        }
        .title {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .input-group-text {
            background-color: #f1f3f5;
            border-right: none;
        }
        .form-control {
            border-left: none;
        }
        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 1rem 0;
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="registration-card">
                    <div class="text-center">
                        <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                        <h2 class="title">StudentSphere Registration</h2>
                    </div>

                    <form action="/Registration" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                                <div class="invalid-feedback">Please enter your name</div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                <div class="invalid-feedback">Please enter a valid email</div>
                            </div>
                        </div>

                        <!-- Roll Number -->
                        <div class="mb-3">
                            <label for="rollno" class="form-label">Roll Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                <input type="text" class="form-control" id="rollno" name="rollno" placeholder="Enter your roll number" required>
                                <div class="invalid-feedback">Please enter your roll number</div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                <div class="invalid-feedback">Please enter a password</div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Year -->
                            <div class="col-md-6 mb-3">
                                <label for="year" class="form-label">Year</label>
                                <select class="form-select" id="year" name="year" required>
                                    <option selected disabled value="">Select Year</option>
                                    <option value="1st year">1st Year</option>
                                    <option value="2nd year">2nd Year</option>
                                    <option value="3rd year">3rd Year</option>
                                    <option value="4th year">4th Year</option>
                                </select>
                                <div class="invalid-feedback">Please select your year</div>
                            </div>

                            <!-- Branch -->
                            <div class="col-md-6 mb-4">
                                <label for="branch" class="form-label">Branch</label>
                                <select class="form-select" id="branch" name="branch" required>
                                    <option selected disabled value="">Select Branch</option>
                                    <option value="CSD">CSD</option>
                                    <option value="CSE">CSE</option>
                                    <option value="AIDS">AIDS</option>
                                    <option value="AIML">AIML</option>
                                </select>
                                <div class="invalid-feedback">Please select your branch</div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <!-- Submit Button -->
                        <button class="btn btn-primary w-100 py-2 mb-3" type="submit">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </button>

                        <p class="text-center text-muted">
                            Already have an account? <a href="/login" class="text-decoration-none text-primary fw-semibold">Login here</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>
