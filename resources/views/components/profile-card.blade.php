@props(['profile'])

<div style="border: 1px solid #ddd; padding: 20px; border-radius: 12px; background: #fff; margin-bottom: 20px; box-shadow: 2px 2px 10px rgba(0,0,0,0.05);">
    <h3 style="margin-top: 0; color: #1a202c;">{{ $profile['name'] }} ({{ $profile['age'] }})</h3>
    <p><strong>Program:</strong> {{ $profile['program'] }}</p>
    <p><strong>Email:</strong> {{ $profile['email'] }}</p>
    <p><strong>Gender:</strong> {{ ucfirst($profile['gender']) }}</p>
    <div>
        <strong>Hobbies:</strong>
        @foreach($profile['hobbies'] as $hobby)
            <span style="background: #edf2f7; padding: 2px 8px; border-radius: 4px; font-size: 0.85em; margin-right: 5px;">{{ trim($hobby) }}</span>
        @endforeach
    </div>
    <p style="margin-top: 10px; font-style: italic; color: #4a5568;">"{{ $profile['bio'] }}"</p>
</div>