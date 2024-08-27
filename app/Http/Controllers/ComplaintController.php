<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaints;
use App\Models\Office;

class ComplaintController extends Controller
{
    public function index (Request $request)
    {
        $offices = Office::all();

        return view('page')->with('offices', $offices);
    }

    public function create (Request $request) 
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
        
        return redirect('/')->with('success', true);
    }

    public function view ($id)
    {
        $complaint = Complaints::where('id', $id)->first();
        $office = Office::where('id', $complaint->office_id)->first();

        return view('complaint')->with(['complaint' => $complaint, 'office' => $office]);
    }

    public function update_status (Request $request, $id)
    {
        $complaint = Complaints::where('id', $id)->first();

        $complaint->status = $request->status;

        $complaint->save();

        return redirect('/qao');
    }
}
