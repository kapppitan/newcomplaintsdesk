<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Complaints;
use App\Models\Office;
use App\Models\Ticket;
use App\Models\Form;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->user()->update(['last_activity' => Carbon::now()]);

            return match ($request->user()->office_id) {
                1 => redirect('/qao'),
                2 => redirect('/qmso'),
                default => redirect('/office'),
            };
        }

        return redirect('/login')->with('error', true);
    }


    public function logout (Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function qmso_index (request $request)
    {
        $complaints = Complaints::where('phase', 3)->get();
        $auth = Auth::user();

        return view('qmso')->with(['complaints' => $complaints, 'auth' => $auth]);
    }

    public function qao_index (Request $request)
    {
        if (Auth::user()->office_id == 1) {
            $complaints = Complaints::all();
            $tcomplaints = Complaints::orderBy('ticket_id')->get();
            $office = Office::with('users')->get();
            $ticket = Ticket::all();

            $pending = Complaints::where('status', 0)->count();
            $processing = Complaints::whereIn('status', [1, 3])->count();
            $closed = Complaints::where('status', 4)->count();

            $forms = Form::all();

            $new_complaints = Complaints::where('is_read', false)->where('created_at', '<', Auth::user()->last_activity)->get();

            $user = User::where('id', Auth::user()->id)->first();
            $user->last_activity = Carbon::now();
            $user->save();

            return view('qao')->with([
                'complaints'=> $complaints, 
                'offices' => $office , 
                'pending' => $pending, 
                'processing' => $processing, 
                'tickets' => $ticket, 
                'form' => $forms, 
                'tcomplaints' => $tcomplaints, 
                'new_complaints' => $new_complaints,
                'closed' => $closed,
                'notifShown' => session('notifShown', false),
            ]);
        } else {
            return $this->office_index($request);
        }
    }

    public function office_index (Request $request)
    {
        if(Auth::user()->office_id != 1) {
            $complaints = Complaints::where('office_id', Auth::user()->office_id)->where('has_form', true)->get();
            $inbox = Complaints::where('office_id', Auth::user()->office_id)->where('has_form', true)->where('phase', 1)->get();
            $outbox = Complaints::where('office_id', Auth::user()->office_id)->where('has_form', true)->where('phase', 2)->get();

            $year = date('Y');
            $complaint = Complaints::whereYear('created_at', $year)
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
                ->orderBy('month')
                ->get();
    
            $months = [];
            $counts = [];
    
            for ($i = 1; $i <= 12; $i++) {
                $monthData = $complaint->where('month', $i)->first();
                $months[] = Carbon::create()->month($i)->format('F');
                $counts[] = $monthData ? $monthData->count : 0;
            }

            $data = [
                'labels' => $months,
                'dataset' => $counts
            ];

            $office = Office::where('id', Auth::user()->office_id)->first();

            return view('office')->with(['data' => $data,'complaints' => $complaints, 'office' => $office, 'inbox' => $inbox, 'outbox' => $outbox]);
        } elseif (Auth::user()->office_id == 1) {
            return $this->qao_index($request);
        }
    }

    public function return (Request $request)
    {
        return redirect('/qao')->with('success-complaint', true);
    }

    public function create_account (Request $request)
    {
        $account = new User();

        $account->username = $request->input('username');
        $account->password = $request->input('password');
        $account->office_id = $request->input('office');

        $account->save();

        return redirect('/qao')->with('success-create', true);
    }

    public function create_office (Request $request)
    {
        $office = new Office();

        $office->office_name = $request->input('office-name');

        $office->save();

        return redirect('/qao')->with('success-create', true);
    }

    public function memo_index (Request $request, $id)
    {
        $complaint = Complaints::where('id', $id)->first();
        $memo = Memo::where('complaint_id', $complaint->id)->first();

        // return response()->json($memo);
        return view('memo')->with(['complaint' => $complaint, 'memo' => $memo]);
    }

    public function get_user ($id)
    {
        $user = User::find($id);
        $office = Office::find($user->office_id);

        return response()->json([
            'user' => $user,
            'office' => $office,
        ]);
    }

    public function get_complaints (Request $request)
    {
        $year = date('Y');
        $complaints = Complaints::whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
            ->orderBy('month')
            ->get();

        $months = [];
        $counts = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthData = $complaints->where('month', $i)->first();
            $months[] = Carbon::create()->month($i)->format('F');
            $counts[] = $monthData ? $monthData->count : 0;
        }

        return response()->json([
            'labels' => $months,
            'dataset' => $counts
        ]);
    }

    public function update_profile (Request $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            $fieldsToUpdate = ['name', 'username'];
    
            foreach ($fieldsToUpdate as $field) {
                if (!empty($request->$field)) {
                    $user->$field = $request->$field;
                }
            }

            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }
            
            $user->save();
        }

        return redirect()->back();
    }
}
