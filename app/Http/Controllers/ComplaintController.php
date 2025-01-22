<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Models\Complaints;
use App\Models\Memo;
use App\Models\Office;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Corrective;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $complaint->user_type = $request->input('type');
        $complaint->complaint_type = $request->input('complaint_type');
        $complaint->details = $request->input('details');
        $complaint->email = $request->input('email');
        $complaint->phone = $request->input('phone');
        $complaint->status = 'Pending';

        $file = $request->file('file')->store('evidence', 'public');
        $complaint->image_path = $file;

        $complaint->office_id = $request->input('recipient');

        $complaint->save();
        
        return redirect('/')->with(['success' => true]);
    }

    public function view ($id)
    {
        $complaint = Complaints::where('id', $id)->first();
        $office = Office::find($complaint->office_id);

        $complaint->is_read = true;
        $complaint->save();

        return response()->json([
            'created_at' => $complaint->created_at,
            'ago' => Carbon::parse($complaint->created_at)->diffForHumans(),
            'details' => $complaint->details,
            'office' => $office,
            'name' => $complaint->name,
            'type' => $complaint->user_type,
            'email' => $complaint->email,
            'number' => $complaint->phone,
            'status' => $complaint->status,
            'evidence' => $complaint->image_path,
            'has_memo' => $complaint->has_memo,
        ]);
    }

    public function update_status (Request $request, $id)
    {
        $complaint = Complaints::where('id', $id)->first();

        $complaint->status = $request->cstatus;
        $complaint->is_read = false;

        if ($request->cstatus == 'Processing' and $complaint->ticket_id == null)
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
        $offices = User::all();
        $users = User::where('office_id', Auth::user()->office_id)->get();
        $auth = Auth::user();
        $form = Form::where('complaint_id', $id)->first();
        $corrective = Corrective::where('complaint_id', $id)->get();

        return view('form')->with(['complaint' => $complaint, 'users' => $users, 'auth' => $auth, 'form' => $form, 'corrective' => $corrective, 'offices' => $offices]);        
    }

    public function submit_ccf(Request $request, $id)
    {
        $form = Form::firstOrNew(['complaint_id' => $id]);
        $form->complaint_id = $id;

        $form->complaint_phase = 1;

        $form->validated_by = $request->validated_by ?? $form->validated_by;
        $form->validated_on = $request->validated_on ?? $form->validated_on;
        $form->acknowledgedqao_by = $request->acknowledgedqao_by ?? $form->acknowledgedqao_by;
        $form->acknowledgedqao_on = $request->acknowledgedqao_on ?? $form->acknowledgedqao_on;
        $form->immediate_action = $request->immediate_action ?? $form->immediate_action;
        $form->consequence = $request->consequence ?? $form->consequence;
        $form->root_cause = $request->root_cause ?? $form->root_cause;
        $form->nonconformity = $request->nonconformity ?? $form->nonconformity;

        foreach ($request->input('corrective_action', []) as $index => $actionData) {
            if (
                isset($actionData['corrective_action'], $actionData['implementation'], $actionData['effectiveness'], 
                      $actionData['period'], $actionData['responsible'])
            ) {
                Corrective::create([
                    'corrective_action' => $actionData['corrective_action'],
                    'implementation_date' => $actionData['implementation'],
                    'effectiveness' => $actionData['effectiveness'],
                    'monitoring_period' => $actionData['period'],
                    'responsible' => $actionData['responsible'],
                    'complaint_id' => $id,
                ]);
            }
        }
        

        $form->risk_opportunity = $request->risk_opportunity ?? $form->risk_opportunity;
        $form->changes = $request->changes ?? $form->changes;

        $form->prepared_by = $request->prepared_by ?? $form->prepared_by;
        $form->prepared_on = $request->prepared_on ?? $form->prepared_on;
        $form->approved_by = $request->approved_by ?? $form->approved_by;
        $form->approved_on = $request->approved_on ?? $form->approved_on;
        $form->acknowledged_by = $request->acknowledged_by ?? $form->acknowledged_by;
        $form->acknowledged_on = $request->acknowledged_on ?? $form->acknowledged_on;

        $form->feedback = $request->feedback ?? $form->feedback;

        $form->reported_by = $request->reported_by ?? $form->reported_by;
        if ($request->reported_by != null) {
            $form->date_reported = Carbon::now();
        }
        
        $form->is_approved = (int) $request->input('accept');
        $form->further_action = $request->reasons ?? $form->further_action;

        $form->save();

        $complaint = Complaints::where('id', $id)->first();
        $complaint->has_form = true;

        if ($complaint->phase < 3) {
            $complaint->phase += 1;
        }

        $complaint->save();

        return redirect(Auth::user()->office_id == 1 ? '/qao' : '/office/' . Auth::user()->office_id);
    }

    public function submit_memo (Request $request, $id)
    {
        $complaint = Complaints::where('id', $id)->first();
        $memo = new Memo();

        $memo->content = $request->content;
        $memo->for = $request->recipient;
        $memo->from = $request->sender;
        $memo->for_role = $request->recipient_role;
        $memo->from_role = $request->sender_role;
        $memo->complaint_id = Complaints::where('id', $id)->first()->id;
        $complaint->has_memo = true;
        
        $complaint->save();
        $memo->save();

        return redirect('/qao')->with('complaint', true);
    }

    public function print_ccf (Request $request, $id)
    {
        $complaint = Complaints::where('id', $id)->first();
        $corrective = Corrective::where('complaint_id', $complaint->id)->get();
        $users = User::all();
        $form = Form::where('complaint_id', $complaint->id)->first();

        return view('complaint_print')->with(['complaint' => $complaint, 'form' => $form, 'users' => $users, 'corrective' => $corrective]);
    }

    public function print_memo (Request $request, $id)
    {
        $complaint = Complaints::where('id', $id)->first();
        $memo = Memo::where('complaint_id', $id)->first();

        return view('memo_print')->with(['complaint' => $complaint, 'memo' => $memo]);
    }

    public function open_close (Request $request, $id)
    {
        $complaint = Complaints::where('id', $id)->first();

        $complaint->is_closed = $request->cstatus;
        $complaint->status = 'Closed';
        $complaint->verified_at = Carbon::now();
        $complaint->save();

        return redirect('/corrective/' . $id)->with('closed', true);
    }

    public function form_view ($id)
    {
        $complaint = Complaints::where('id', $id)->first();
        $corrective = Corrective::where('complaint_id', $id)->get();

        return view('correctives')->with(['corrective' => $corrective, 'complaint' => $complaint]);
    }

    public function monitor ($id)
    {
        $complaint = Complaints::where('id', $id)->first();
        $complaint->is_monitored = true;
        $complaint->save();

        return redirect('/corrective/' . $id)->with('monitored', True);
    }

    public function accept (Request $request, $id) 
    {
        $corrective = Corrective::where('id', $id)->first();
        $corrective->comment = $request->feedback;
        $corrective->is_approved = $request->accepted;

        $corrective->save();

        return back();
    }

    public function upload (Request $request, $id)
    {
        $corrective = Corrective::where('id', $id)->first();
        $file = $request->file('ufile')->store('evidence', 'public');
        $corrective->document = $file;
        $corrective->save();

        return back();
    }

    public function download (Request $request, $id)
    {
        $corrective = Corrective::find($id);
        $path = $corrective->document;

        if (Storage::disk('public')->exists($path)) {
            return Storage::download('public/' . $path);
        } else {
            return redirect()->back();
        }
    }
}
