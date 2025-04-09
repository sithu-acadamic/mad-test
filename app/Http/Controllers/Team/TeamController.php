<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Models\Team\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::latest()->paginate(10);
        return view('team.index', compact('teams'));
    }

    public function store(TeamRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('team_images', 'public');
        }

        Team::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'designation' => $request->designation,
            'image' => $imagePath,
            'status' => 1, // Default status is active
        ]);

        return response()->json(['message' => 'Team member added successfully!']);
    }

    public function update(TeamRequest $request, $id)
    {
        $team = Team::findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('team_images', 'public');
        } else {
            $imagePath = $team->image;
        }

        $team->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'designation' => $request->designation,
            'image' => $imagePath,
        ]);

        return response()->json(['message' => 'Team member updated successfully!']);
    }

    public function destroy($id)
    {
        Team::findOrFail($id)->delete();
        return response()->json(['message' => 'Team member deleted successfully!']);
    }

    public function toggleStatus($id)
    {
        $team = Team::findOrFail($id);
        $team->status = !$team->status;
        $team->save();

        return response()->json(['message' => 'Status updated successfully!']);
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Team::where('id', $item['id'])->update(['index' => $item['index']]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }

}
