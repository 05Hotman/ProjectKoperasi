<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Queue\Events\Looping;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $nasabah
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $user = Customer::all();
    $totalCustomers = DB::table('customers')
        ->select(DB::raw('MONTH(joined_at) as month'), DB::raw('COUNT(*) as total'))
        ->whereYear('joined_at', date('Y'))
        ->groupBy(DB::raw('MONTH(joined_at)'))
        ->pluck('total', 'month')
        ->toArray();

    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $customerData = [];

    foreach ($months as $month) {
        if (isset($totalCustomers[$month])) {
            $customerData[] = $totalCustomers[$month];
        } else {
            $customerData[] = null;
        }
    }

    $totalDepositPokok = Deposit::where('type', 'pokok')
        ->whereMonth('created_at', Carbon::now()->month)
        ->sum('amount');
    $totalDepositWajib = Deposit::where('type', 'wajib')
        ->whereMonth('created_at', Carbon::now()->month)
        ->sum('amount');
    $totalDepositSukarela = Deposit::where('type', 'sukarela')
        ->whereMonth('created_at', Carbon::now()->month)
        ->sum('amount');
    $totalDepositPenarikan = Deposit::where('type', 'penarikan')
        ->whereMonth('created_at', Carbon::now()->month)
        ->sum('amount');

    return view('pages.dashboard', [
        'title' => 'Dashboard',
        'user' => $user,
        'totalCustomers' => $totalCustomers,
        'totalDepositPokok' => $totalDepositPokok,
        'totalDepositWajib' => $totalDepositWajib,
        'totalDepositSukarela' => $totalDepositSukarela,
        'totalDepositPenarikan' => $totalDepositPenarikan,
        'customerData' => $customerData,
    ]);
}


    public function profile()
    {
        return view('pages.profile', [
            'title' => 'Pengaturan',
            'profile' => Auth::user()
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $user = Auth::user();
            $data = $request->except('photo');
            $data['photo'] = $this->updateImage($request, $user->photo);
            $user->update($data);
            return back()->with('success', 'Berhasil mengupdate profil!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function truncate()
    {
        try {
            Artisan::call('migrate:fresh --seed');
            Auth::logout();
            return back()->with('success', 'Berhasil mereset data!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
