<style>
.msprofile-wrap { max-width: 900px; }
.msprofile-card { background:#fff; border-radius:14px; box-shadow:0 1px 4px rgba(0,0,0,.08); padding:2rem; margin-bottom:1.5rem; }
.msprofile-top { display:flex; gap:2rem; align-items:flex-start; flex-wrap:wrap; }
.msprofile-avatar-wrap { text-align:center; }
.msprofile-avatar { width:120px; height:120px; border-radius:50%; overflow:hidden; background:#f5f0e8; display:flex; align-items:center; justify-content:center; margin:0 auto .75rem; cursor:pointer; border:3px solid #f0d9b5; }
.msprofile-avatar img { width:100%; height:100%; object-fit:cover; }
.msprofile-avatar span { font-size:2rem; font-weight:700; color:#c47a1a; }
.msprofile-photo-btn { background:#c47a1a; color:#fff; border:none; border-radius:6px; padding:6px 14px; font-size:.8rem; cursor:pointer; }
.msprofile-info h5 { margin-bottom:1rem; font-weight:700; }
.msprofile-row { display:flex; padding:.4rem 0; border-bottom:1px solid #f2f2f2; font-size:.92rem; }
.msprofile-row .label { width:150px; color:#888; flex-shrink:0; }
.msprofile-row .value { font-weight:600; color:#222; }
.msprofile-edit-btn { margin-top:1rem; background:#fff; border:1px solid #c47a1a; color:#c47a1a; border-radius:6px; padding:6px 16px; font-size:.85rem; cursor:pointer; }
.msprofile-stats { display:flex; gap:1rem; margin-top:1.5rem; padding-top:1.5rem; border-top:1px solid #eee; text-align:center; }
.msprofile-stats > div { flex:1; }
.msprofile-stats h3 { margin:0; font-size:1.5rem; }
.msprofile-edit-form { display:none; margin-top:1.5rem; padding-top:1.5rem; border-top:1px solid #eee; }
.msprofile-edit-form.open { display:block; }
.msprofile-edit-form label { font-size:.8rem; font-weight:600; color:#555; display:block; margin-bottom:4px; }
.msprofile-edit-form input { width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:6px; margin-bottom:14px; font-size:.9rem; box-sizing:border-box; }
.msprofile-save-btn { background:#c47a1a; color:#fff; border:none; border-radius:6px; padding:8px 20px; font-size:.9rem; cursor:pointer; }
.msprofile-alert-ok { background:#e6f7ea; color:#2fa84f; padding:10px 16px; border-radius:8px; margin-bottom:1rem; }
.msprofile-alert-err { background:#fdeae8; color:#e1483c; padding:10px 16px; border-radius:8px; margin-bottom:1rem; }
</style>

@if(session('success'))
    <div class="msprofile-alert-ok">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="msprofile-alert-err">
        @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
    </div>
@endif

<div class="msprofile-wrap">
  <div class="msprofile-card">
    <div class="msprofile-top">
      <div class="msprofile-avatar-wrap">
        <form method="POST" action="{{ route($photoRoute) }}" enctype="multipart/form-data" id="msPhotoForm">
          @csrf
          <label for="msPhotoInput" class="msprofile-avatar">
            @if($user->photo ?? null)
              <img src="{{ asset('storage/'.$user->photo) }}" alt="Photo de profil">
            @else
              <span>{{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}</span>
            @endif
          </label>
          <input type="file" id="msPhotoInput" name="photo" accept="image/*" style="display:none;">
          <button type="button" class="msprofile-photo-btn" onclick="document.getElementById('msPhotoInput').click();">
            Change Photo
          </button>
        </form>
      </div>

      <div class="msprofile-info" style="flex:1;min-width:250px;">
        <h5>My Profile</h5>
        <div class="msprofile-row"><div class="label">Full Name:</div><div class="value">{{ $user->name }}</div></div>
        <div class="msprofile-row"><div class="label">Email:</div><div class="value">{{ $user->email }}</div></div>
        <div class="msprofile-row"><div class="label">Phone:</div><div class="value">{{ $user->phone }}</div></div>
        <div class="msprofile-row"><div class="label">Role:</div><div class="value">{{ $user->role }}</div></div>
        <div class="msprofile-row"><div class="label">Department:</div><div class="value">{{ $user->department }}</div></div>
        <div class="msprofile-row"><div class="label">Joined:</div><div class="value">{{ $user->joined }}</div></div>

        <button type="button" class="msprofile-edit-btn" onclick="document.getElementById('msEditForm').classList.toggle('open')">
          Edit Profile
        </button>

        <form method="POST" action="{{ route($updateRoute) }}" class="msprofile-edit-form" id="msEditForm">
          @csrf
          @method('PUT')
          <label>Full Name</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
          <label>Phone</label>
          <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
          <button type="submit" class="msprofile-save-btn">Save Changes</button>
        </form>
      </div>
    </div>

    <div class="msprofile-stats">
      <div><h3 style="color:#c47a1a;">{{ $user->login_count }}</h3><small class="text-muted">Login Count</small></div>
      <div><h3 style="color:#2fa84f;">{{ $user->account_status }}</h3><small class="text-muted">Account Status</small></div>
      <div><h3>{{ $user->security_level }}</h3><small class="text-muted">Security Level</small></div>
    </div>
  </div>
</div>

<script>
document.getElementById('msPhotoInput').addEventListener('change', function () {
    if (this.files && this.files.length > 0) {
        document.getElementById('msPhotoForm').submit();
    }
});
@if($errors->any())
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('msEditForm').classList.add('open');
});
@endif
</script>