<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = session('profiles', []);
        return view('welcome', compact('profiles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'age' => 'required|numeric',
            'program' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'hobbies' => 'required', // Activity requires at least 5 hobbies
            'bio' => 'required',
        ]);

        $profiles = session()->get('profiles', []);

        if ($request->filled('profile_index')) {
            $index = $request->profile_index;
            $profiles[$index] = $data;
            session()->put('profiles', $profiles);
        } else {
            session()->push('profiles', $data);
        }

        return redirect()->route('profile.index');
    }

    public function deleteOne($index)
    {
        $profiles = session()->get('profiles', []);
        
        if (isset($profiles[$index])) {
            unset($profiles[$index]);
            // array_values is critical to reset keys (0, 1, 2) and prevent route errors
            session()->put('profiles', array_values($profiles));
        }
        
        return redirect()->route('profile.index');
    }

    public function clear()
    {
        session()->forget('profiles'); // Required "Clear All" button functionality
        return redirect()->route('profile.index');
    }
}