<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Complaints;
use App\Models\Office;
use App\Models\Ticket;
use App\Models\Form;
use App\Models\Memo;
use App\Models\Notifications;
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
            $request->session()->regenerate();
            $request->user()->update(['last_activity' => Carbon::now()]);

            return match ($request->user()->office_id) {
                1 => redirect()->intended('/qao'),
                2 => redirect()->intended('/qmso'),
                default => redirect()->intended('/office/' . $request->user()->id),
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

        $lastActivity = Auth::user()->last_activity ?? Auth::user()->created_at;
        $new_complaints = Complaints::where('phase', 3)->where('created_at', '>', $lastActivity)->get();

        if (!$request->session()->has('seen')) {
            $request->session()->put('seen', true);
            $seen = true;
        } else {
            $seen = false;
        }

        return view('qmso')->with(['complaints' => $complaints, 'auth' => $auth, 'new_complaints' => $new_complaints, 'seen' => $seen]);
    }

    public function qao_index (Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->office_id == 1) {
                $complaints = Complaints::all();
                $tcomplaints = Complaints::orderBy('ticket_id')->get();
                $office = Office::with(relations: 'users')->get();
                $ticket = Ticket::all();

                $pending = Complaints::where('status', 'Pending')->count();
                $processing = Complaints::where('status', 'Processing')->count();
                $closed = Complaints::where('status', 'Closed')->count();

                $forms = Form::all();

                $lastActivity = Auth::user()->last_activity ?? Auth::user()->created_at;
                $new_complaints = Complaints::where('is_read', false)->where('created_at', '>', $lastActivity)->get();
                $returned_complaints = Complaints::where('phase', 2)->where('updated_at', '>', $lastActivity)->get();
                $closedc = Complaints::where('status', 'Closed')->where('updated_at', '>', $lastActivity)->get();

                $user = User::where('id', Auth::user()->id)->first();
                $user->last_activity = Carbon::now();
                $user->save();

                if (!$request->session()->has('seen')) {
                    $request->session()->put('seen', true);
                    $seen = true;
                } else {
                    $seen = false;
                }

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
                    'seen' => $seen,
                    'returned' => $returned_complaints,
                    'closedc' => $closedc
                ]);
            } else {
                return $this->office_index($request, Auth::user()->id);
            }
        }
    }

    public function office_index(Request $request, $id)
    {
        if (Auth::user()->office_id != 1) {
            $complaints = Complaints::where('office_id', Auth::user()->office_id)->where('has_form', true)->get();
            $inbox = Complaints::where('office_id', Auth::user()->office_id)->where('has_form', true)->where('phase', 1)->get();
            $outbox = Complaints::where('office_id', Auth::user()->office_id)->where('is_monitored', true)->get();

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

            if (!$request->session()->has('seen')) {
                $request->session()->put('seen', true);
                $seen = true;
            } else {
                $seen = false;
            }

            $lastActivity = Auth::user()->last_activity ?? Auth::user()->created_at;
            $new_complaints = Complaints::where('office_id', Auth::user()->id)->where('phase', 1)->where('updated_at', '>', $lastActivity)->get();
            $monitored = Complaints::where('office_id', Auth::user()->id)->where('is_monitored', true)->where('updated_at', '>', $lastActivity)->get();

            dd($monitored->count());

            return view('office')->with([
                'data' => $data,
                'complaints' => $complaints,
                'office' => $office,
                'inbox' => $inbox,
                'outbox' => $outbox,
                'seen' => $seen,
                'new_complaints' => $new_complaints,
                'new_monitor' => $monitored,
            ]);
        } elseif (Auth::user()->office_id == 1) {
            return $this->qao_index($request);
        }
    }

    public function getComplaintsByMonth($month)
    {
        $year = date('Y');

        $complaint = Complaints::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('count(*) as count'))
            ->orderBy('day')
            ->get();

        $days = range(1, Carbon::create($year, $month)->daysInMonth);
        $counts = array_fill(0, count($days), 0);

        foreach ($complaint as $data) {
            $counts[$data->day - 1] = $data->count;
        }

        return response()->json([
            'labels' => $days,
            'dataset' => $counts
        ]);
    }

    public function return (Request $request)
    {
        return redirect('/qao')->with('success-complaint', true);
    }

    public function create_account (Request $request)
    {
        $account = new User();

        $account->username = $request->input('username');
        $account->name = $request->input('name');
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

    public function delete_user (Request $request, $id)
    {
        $user = User::find($id);
        
        if ($user) {
            $user->delete();
            return redirect('/qao')->with('delete', 'Account deleted.');
        }

        return response()->json(['delete' => 'Error']);
    }

    public function delete_office (Request $request) {
        $office = Office::find($request->deleteoffice);

        if ($office) {
            $office->delete();
            return redirect('/qao')->with('delete', 'Office delted.');
        }

        return response()->json(['delete' => 'Error']);
    }
}
