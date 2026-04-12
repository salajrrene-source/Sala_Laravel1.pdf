<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Generator</title>
    <style>
    body { 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        /* Modern Gradient Background */
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        background-attachment: fixed;
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        padding: 40px 20px; 
        min-height: 100vh;
        margin: 0;
    }

    /* Glassmorphism Card Style */
    .card { 
        background: rgba(255, 255, 255, 0.2); 
        backdrop-filter: blur(15px); 
        -webkit-backdrop-filter: blur(15px);
        padding: 30px; 
        border-radius: 20px; 
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2); 
        width: 100%; 
        max-width: 500px; 
        margin-bottom: 40px; 
        color: white;
    }

    h2 { 
        text-align: center; 
        margin-top: 0; 
        font-weight: 600; 
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .form-group { margin-bottom: 20px; }

    /* Input Styling */
    input, select, textarea { 
        width: 100%; 
        padding: 12px; 
        margin-top: 8px; 
        border: 1px solid rgba(255, 255, 255, 0.4); 
        border-radius: 10px; 
        background: rgba(255, 255, 255, 0.9);
        box-sizing: border-box; 
        outline: none; 
        transition: all 0.3s ease;
    }

    input:focus, select:focus, textarea:focus {
        border-color: #667eea;
        box-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
    }

    /* Button Styling */
    .btn-save { 
        width: 100%; 
        padding: 14px; 
        background: #4facfe;
        background: linear-gradient(to right, #00f2fe 0%, #4facfe 100%);
        color: white; 
        border: none; 
        border-radius: 10px; 
        font-size: 16px;
        font-weight: bold; 
        cursor: pointer; 
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-cancel { 
        width: 100%; 
        padding: 10px; 
        background: #ff758c; 
        color: white; 
        border: none; 
        border-radius: 10px; 
        cursor: pointer; 
        display: none; 
        margin-top: 10px; 
        font-weight: bold;
    }

    /* Table Glassmorphism */
    .table-container { 
        width: 95%; 
        max-width: 1200px; 
        background: rgba(255, 255, 255, 0.15); 
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 25px; 
        border-radius: 20px; 
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); 
        overflow-x: auto; 
        color: white;
    }

    table { width: 100%; border-collapse: collapse; min-width: 800px; }
    
    th { 
        background: rgba(255, 255, 255, 0.2); 
        padding: 15px;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
    }

    td { 
        padding: 15px; 
        border-bottom: 1px solid rgba(255, 255, 255, 0.1); 
        font-size: 14px; 
    }

    tr:hover { background: rgba(255, 255, 255, 0.05); }

    /* Action Buttons */
    .btn-edit { 
        background: #f6d365; 
        background: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
        color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: bold;
    }

    .btn-delete { 
        background: #ff0844; 
        background: linear-gradient(to top, #ff0844 0%, #ffb199 100%);
        color: white; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: bold; display: inline-block;
    }

    .btn-clear { 
        background: #434343; 
        background: linear-gradient(to top, #2c1218 0%, #a12904 100%);
        color: white; border: none; padding: 12px 25px; border-radius: 10px; cursor: pointer; margin-top: 20px; font-weight: bold;
    }
</style>
</head>
<body>

    <div class="card">
        <h2 id="form-title">Create Profile</h2>
        <form action="{{ route('profile.store') }}" method="POST" id="profileForm">
            @csrf
            <input type="hidden" name="profile_index" id="profile_index">
            <div class="form-group"><input type="text" name="name" id="name" placeholder="Full Name" required></div>
            <div class="form-group"><input type="number" name="age" id="age" placeholder="Age" required></div>
            <div class="form-group"><input type="text" name="program" id="program" placeholder="Program" required></div>
            <div class="form-group"><input type="email" name="email" id="email" placeholder="Email" required></div>
            <div class="form-group">
                <select name="gender" id="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-group"><input type="text" name="hobbies" id="hobbies" placeholder="Hobbies (Enter at least 5)" required></div>
            <div class="form-group"><textarea name="bio" id="bio" placeholder="Biography" rows="3" required></textarea></div>
            
            <button type="submit" class="btn-save" id="submit-btn">Save Profile</button>
            <button type="button" class="btn-cancel" id="cancel-btn" onclick="cancelEdit()">Cancel Edit</button>
        </form>
    </div>

    <div class="table-container">
        <h2>Saved Student Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Program</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Hobbies</th>
                    <th>Bio</th>
                    <th style="min-width: 130px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($profiles as $index => $p)
                <tr>
                    <td>{{ $p['name'] }}</td>
                    <td>{{ $p['age'] }}</td>
                    <td>{{ $p['program'] }}</td>
                    <td>{{ $p['email'] }}</td>
                    <td>{{ $p['gender'] }}</td>
                    <td>
                        {{-- If hobbies is an array, join it; otherwise show as is --}}
                        {{ is_array($p['hobbies']) ? implode(', ', $p['hobbies']) : $p['hobbies'] }}
                    </td>
                    <td>{{ Str::limit($p['bio'], 30) }}</td>
                    <td>
                        <button type="button" class="btn-edit" onclick="editProfile({{ $index }}, {{ json_encode($p) }})">Edit</button>
                        <a href="{{ route('profile.delete', ['index' => $index]) }}" class="btn-delete" onclick="return confirm('Delete this record?')">Delete</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;">No student records found.</td></tr>
                @endforelse
            </tbody>
        </table>

        @if(count($profiles) > 0)
            <div style="text-align: right;">
                <form action="{{ route('profile.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-clear">Clear All Profiles</button>
                </form>
            </div>
        @endif
    </div>

    <script>
        function editProfile(index, data) {
            document.getElementById('form-title').innerText = "Edit Profile";
            document.getElementById('submit-btn').innerText = "Update Profile";
            document.getElementById('cancel-btn').style.display = "block";
            
            document.getElementById('profile_index').value = index;
            document.getElementById('name').value = data.name;
            document.getElementById('age').value = data.age;
            document.getElementById('program').value = data.program;
            document.getElementById('email').value = data.email;
            document.getElementById('gender').value = data.gender;
            
            // Handle hobbies if it comes back as an array from the session
            let hobbyValue = Array.isArray(data.hobbies) ? data.hobbies.join(', ') : data.hobbies;
            document.getElementById('hobbies').value = hobbyValue;
            
            document.getElementById('bio').value = data.bio;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function cancelEdit() {
            document.getElementById('form-title').innerText = "Create Profile";
            document.getElementById('submit-btn').innerText = "Save Profile";
            document.getElementById('cancel-btn').style.display = "none";
            document.getElementById('profileForm').reset();
            document.getElementById('profile_index').value = "";
        }
    </script>
</body>
</html>