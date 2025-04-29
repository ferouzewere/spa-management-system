<div class="card">
    <div class="card-header bg-secondary text-white">Account Settings</div>
    <div class="card-body">
        <form id="profile-settings-form" action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone }}">
            </div>

            <hr>

            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password">
                <small class="form-text text-muted">Required to change password</small>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
            </div>

            <hr>

            <h5 class="mb-3">Notification Preferences</h5>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="email_notifications" name="preferences[email_notifications]" {{ Auth::user()->preferences['email_notifications'] ?? false ? 'checked' : '' }}>
                    <label class="form-check-label" for="email_notifications">
                        Email Notifications
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="sms_notifications" name="preferences[sms_notifications]" {{ Auth::user()->preferences['sms_notifications'] ?? false ? 'checked' : '' }}>
                    <label class="form-check-label" for="sms_notifications">
                        SMS Notifications
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('profile-settings-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Settings updated successfully');
                } else {
                    alert(data.message || 'An error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving your settings');
            });
    });
</script>
@endpush