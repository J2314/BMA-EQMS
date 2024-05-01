<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function addAnnouncement(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'department_id' => 'required|numeric|exists:departments,id',
            'description' => 'required|string',
            'content' => 'required|string'
        ]);
        
        // $existingDepartment = Department::where('name', $validatedData['name'])
        //     ->orWhere('code', $validatedData['code'])
        //     ->first();

        // if ($existingDepartment) {
        //     return response()->json(['message' => 'Department with the same name or code already exists'], 400);
        // }

        try {
            $announcement = new Announcement();

            $announcement->title = $request->input('title');
            $announcement->department_id = $request->input('department_id');
            $announcement->description = $request->input('description');
            $announcement->content = $request->input('content');

            $announcement->save();

            return response()->json(['message' => 'Announcement added successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add Announcement'], 500);
        }
    }
}
