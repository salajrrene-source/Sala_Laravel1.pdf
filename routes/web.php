<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// 1. Display the Form and Saved Profiles
Route::get('/', function () {
    $profiles = session('profiles', []);
    return view('welcome', compact('profiles'));
})->name('profile.index');

// 2. Add or Update a Profile
Route::post('/add-profile', function (Request $request) {
    $data = $request->only(['name', 'age', 'program', 'email', 'gender', 'bio']);
    $data['hobbies'] = explode(',', $request->hobbies);
    
    $profiles = session()->get('profiles', []);

    // If profile_index is present, we are EDITING
    if ($request->filled('profile_index')) {
        $index = $request->profile_index;
        $profiles[$index] = $data;
        session()->put('profiles', $profiles);
    } else {
        // Otherwise, we are ADDING NEW
        session()->push('profiles', $data);
    }
    
    return redirect()->route('profile.index');
})->name('profile.store');

// 3. Delete ONE specific profile (The missing part)
Route::get('/delete-profile/{index}', function ($index) {
    $profiles = session()->get('profiles', []);
    
    if (isset($profiles[$index])) {
        unset($profiles[$index]);
        // array_values resets keys to 0, 1, 2... to prevent route errors
        session()->put('profiles', array_values($profiles));
    }
    
    return redirect()->route('profile.index');
})->name('profile.delete');

// 4. Clear all stored profiles
Route::post('/clear-profiles', function () {
    session()->forget('profiles');
    return redirect()->route('profile.index');
})->name('profile.clear');