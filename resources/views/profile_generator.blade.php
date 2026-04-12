<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Generator</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: auto; padding: 20px; }
        form div { margin-bottom: 10px; }
        label { display: block; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; }
        .btn-add { background: green; color: white; padding: 10px; border: none; cursor: pointer; }
        .btn-clear { background: red; color: white; padding: 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>

    <h1>Personal Profile Generator</h1>

    <form action="{{ route('profile.store') }}" method="POST">
        @csrf
        <div>
            <label>Full Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Age:</label>
            <input type="number" name="age" required>
        </div>
        <div>
            <label>Program:</label>
            <input type="text" name="program" required>
        </div>
        <div>
            <label>Email Address:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Gender:</label>
            <select name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div>
            <label>Hobbies (Enter 5, separate by comma):</label>
            <input type="text" name="hobbies_input" placeholder="Reading, Coding, etc.">
            <small>Note: Code will split these into an array for you.</small>
        </div>
        <script>
            document.querySelector('form').onsubmit = function() {
                let val = document.querySelector('[name="hobbies_input"]').value;
                let arr = val.split(',').map(s => s.trim()).filter(s => s !== "");
                arr.forEach(h => {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'hobbies[]';
                    input.value = h;
                    this.appendChild(input);
                });
            };
        </script>
        <div>
            <label>Short Biography:</label>
            <textarea name="bio" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn-add">Add Profile</button>
    </form>

    <hr>

    <form action="{{ route('profile.clear') }}" method="POST" style="margin-bottom: 20px;">
        @csrf
        <button type="submit" class="btn-clear">Clear All Profiles</button>
    </form>

    <h2>Saved Profiles</h2>
    @if(count($profiles) > 0)
        @foreach($profiles as $profile)
            <x-profile-card :profile="$profile" />
        @endforeach
    @else
        <p>No profiles added yet.</p>
    @endif

</body>
</html>