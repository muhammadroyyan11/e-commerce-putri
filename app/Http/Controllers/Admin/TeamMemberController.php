<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('order')->get();
        return view('admin.about.team', compact('members'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'position_id' => 'required|string|max:255',
            'position_en' => 'required|string|max:255',
            'bio_id'      => 'nullable|string',
            'bio_en'      => 'nullable|string',
            'order'       => 'integer',
            'is_active'   => 'boolean',
            'photo'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = public_path('uploads/team');
            if (!file_exists($path)) mkdir($path, 0755, true);
            $filename = 'team_' . time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move($path, $filename);
            $data['photo'] = asset('uploads/team/' . $filename);
        }

        $data['is_active'] = $request->boolean('is_active', true);
        TeamMember::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function update(Request $request, TeamMember $team)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'position_id' => 'required|string|max:255',
            'position_en' => 'required|string|max:255',
            'bio_id'      => 'nullable|string',
            'bio_en'      => 'nullable|string',
            'order'       => 'integer',
            'is_active'   => 'boolean',
            'photo'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = public_path('uploads/team');
            if (!file_exists($path)) mkdir($path, 0755, true);
            $filename = 'team_' . time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move($path, $filename);
            $data['photo'] = asset('uploads/team/' . $filename);
        } else {
            unset($data['photo']);
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(TeamMember $team)
    {
        $team->delete();
        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
