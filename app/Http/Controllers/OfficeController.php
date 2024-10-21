<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Complaints;
use App\Models\Office;
use App\Models\Ticket;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficeController extends Controller
{
    public function login (Request $request)
    {
        $credentials = $request->only('username', 'password');

        if(Auth::attempt($credentials)) {
            $user = User::where('username', $request->username)->first();
            $user->last_activity = Carbon::now();
            $user->save();

            if($user->office_id == 1) {
                return redirect('/qao');
            } else {
                return redirect('/office');
            }
        } else {
            return redirect('/login')->with('error', true);
        }
    }

    public function logout (Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function qao_index (Request $request)
    {
        $complaints = Complaints::all();
        $office = Office::with('users')->get();
        $ticket = Ticket::all();
        $pending = Complaints::where('status', 0)->get()->count();
        $processing = Complaints::whereIn('status', [1, 3])->get()->count();
        $forms = Form::all();

        return view('qao')->with(['complaints'=> $complaints, 'offices' => $office , 'pending' => $pending, 'processing' => $processing, 'tickets' => $ticket, 'form' => $forms]);
    }

    public function office_index (Request $request)
    {
        $complaints = Complaints::where('office_id', Auth::user()->office_id)->get();
        $office = Office::where('id', Auth::user()->office_id)->first();

        return view('office')->with(['complaints' => $complaints, 'office' => $office]);
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

    public function view_memo (Request $request)
    {
        return view('memo');
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
}
