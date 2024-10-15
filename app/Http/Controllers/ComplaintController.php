<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Models\Complaints;
use App\Models\Office;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

        if ($request->status == 1 and $complaint->ticket_id == null)
        {
            $ticket = new Ticket();
            $ticket->ticket_number = Ticket::count() + 1;

            $ticket->save();

            $complaint->ticket_id = $ticket->id;
            $complaint->validated_by = Auth::user()->id;
            $complaint->date_verified = Carbon::now();
        }

        $complaint->save();

        return redirect('/qao');
    }

    public function form_index (Request $request, $id)
    {
        $complaint = Complaints::where('id', $id)->first();
        $users = User::where('office_id', Auth::user()->office_id)->get();
        $auth = Auth::user();
        $form = Form::where('complaint_id', $id)->first();

        return view('form')->with(['complaint' => $complaint, 'users' => $users, 'auth' => $auth, 'form' => $form]);
    }

    public function submit_ccf (Request $request, $id)
    {
        $form = Form::firstOrNew(['complaint_id' => $id]);

        $form->complaint_id = $id;
        $form->complaint_phase += 1;

        $form->immediate_action = $request->corrective;
        $form->consequence = $request->consequence;
        $form->root_cause = $request->analysis;
        $form->nonconformity = $request->similar;

        $form->corrective_action = $request->actions;
        $form->implementation = $request->implementation;
        $form->measure = $request->effectiveness;
        $form->period = $request->period;
        $form->responsible = $request->responsible;

        $form->risk_opportunity = $request->risk;
        $form->prepared_by = $request->prepared_by;
        $form->prepared_on = $request->prepared_date;
        $form->approved_by = $request->approved_on;
        $form->approved_on = $request->approved_date;
        $form->acknowledged_by = $request->acknowledged_by;
        $form->acknowledged_on = $request->acknowledge_date;

        $form->save();

        return redirect('/qao/complaint/form/{$id}');
    }

    public function print_ccf (Request $request, $id)
    {
        $complaint = Complaints::where('id', $id)->first();

        return view('complaintprint')->with('complaint', $complaint);
    }
}
