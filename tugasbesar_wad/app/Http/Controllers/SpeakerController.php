<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpeakerController extends Controller
{
    public function index()
    {
        $speakers = Speaker::with('event')->get();
        return view('speakers.index', compact('speakers'));
    }

    public function create()
    {
        $events = Event::all();
        return view('speakers.create', compact('events'));
    }

    // Ambil data dari GitHub API
    public function fetchGithub($username)
    {
        $response = Http::get("https://api.github.com/users/" . $username);

        if ($response->failed()) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        $data = $response->json();

        return response()->json([
            'username_platform' => $data['login'] ?? null,
            'nama_lengkap'      => $data['name'] ?? null,
            'bio_singkat'       => $data['bio'] ?? null,
            'avatar_url'        => $data['avatar_url'] ?? null,
            'instansi'          => $data['company'] ?? null,
            'role_job'          => null
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username_platform' => 'required',
            'nama_lengkap'      => 'required',
            'event_id'          => 'required'
        ]);

        Speaker::create($request->all());
        return redirect()->route('speakers.index');
    }

    public function edit($id)
    {
        $speaker = Speaker::findOrFail($id);
        $events = Event::all();
        return view('speakers.edit', compact('speaker', 'events'));
    }

    public function update(Request $request, $id)
    {
        $speaker = Speaker::findOrFail($id);
        $speaker->update($request->all());
        return redirect()->route('speakers.index');
    }

    public function destroy($id)
    {
        Speaker::destroy($id);
        return back();
    }
}
