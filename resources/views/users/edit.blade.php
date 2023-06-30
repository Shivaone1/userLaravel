
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>
    <div>
        <label for="mobile">Mobile No.:</label>
        <input type="tel" id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}" required>
    </div>
    <div>
        <label for="profile_pic">Profile Pic:</label>
        <input type="file" id="profile_pic" name="profile_pic">
        @if ($user->profile_pic)
            <img src="{{ asset('uploads/' . $user->profile_pic) }}" alt="Profile Picture" style="width: 100px;">
        @endif
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
    </div>
    <div>
        <button type="submit">Save</button>
    </div>
</form>

<a href="{{ route('users.index') }}">Back to List</a>
