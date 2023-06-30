
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="mobile">Mobile No.:</label>
        <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" required>
    </div>
    <div>
        <label for="profile_pic">Profile Pic:</label>
        <input type="file" id="profile_pic" name="profile_pic">
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <button type="submit">Save</button>
    </div>
</form>

<a href="{{ route('users.index') }}">Back to List</a>
