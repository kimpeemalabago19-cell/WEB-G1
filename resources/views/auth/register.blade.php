@extends('layouts.auth')

@section('title', 'Register - CHMSU Lost & Found')

@section('content')
<div class="auth-card">
    <div class="text-center mb-4">
        <h3 class="brand-title">CHMSU Lost & Found</h3>
        <p class="text-muted">Create your account</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger text-center py-2">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success text-center py-2">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                <span class="input-group-text toggle-password" onclick="togglePassword('password','eye1')">
                    <i class="bi bi-eye" id="eye1"></i>
                </span>
            </div>
            <small class="text-muted">Minimum 6 characters</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input type="password" name="password_confirmation" id="confirm" class="form-control" placeholder="Confirm password" required>
                <span class="input-group-text toggle-password" onclick="togglePassword('confirm','eye2')">
                    <i class="bi bi-eye" id="eye2"></i>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Account Role</label>
            <select name="role" id="role-select" class="form-select" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <!-- Admin Secret Field -->
        <div class="mb-3 d-none" id="admin-secret-group">
            <label class="form-label">
                Admin Secret <small class="text-danger">(Required for Admin)</small>
            </label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-key"></i></span>
                <input type="password" name="secret" id="admin-secret" class="form-control" placeholder="Enter admin secret">
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
    </form>

    <div class="text-center mt-3">
        <small>
            Already have an account?
            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Login here</a>
        </small>
    </div>
</div>

<script>
function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);

    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        field.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}

// Show/hide admin secret field
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role-select');
    const secretGroup = document.getElementById('admin-secret-group');
    const secretInput = document.getElementById('admin-secret');

    function toggleSecretField() {
        if (roleSelect.value === 'admin') {
            secretGroup.classList.remove('d-none');
            secretInput.required = true;
        } else {
            secretGroup.classList.add('d-none');
            secretInput.required = false;
            secretInput.value = '';
        }
    }

    roleSelect.addEventListener('change', toggleSecretField);
    toggleSecretField(); // run on load
});
</script>
@endsection