<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaints;

class ComplaintController extends Controller
{
    public function create(Request $request) 
    {
        $request->validate([
            'phone' => 'required|string|min:8|max:11',
        ]);

        $complaint = new Complaints();
        
        $complaint->name = $request->input('name');
        $complaint->user_type = $request->input('user_type');
        $complaint->complaint_type = $request->input('complaint_type');
        $complaint->details = $request->input('details');
        $complaint->email = $request->input('email');
        $complaint->phone = $request->input('phone');

        $file = $request->file('file')->store('evidence');
        $complaint->image_path = $file;

        $complaint->office_id = $request->input('recipient');

        $complaint->save();
        
        return redirect('/')->with('error', false);
    }
}
