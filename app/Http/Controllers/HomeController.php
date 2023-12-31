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
        // Mengambil total pelanggan berdasarkan bulan
        // $totalCustomers = DB::table('customers')
        // ->select(DB::raw('MONTH(joined_at) as month'), DB::raw('COUNT(*) as total'))
        // ->whereYear('joined_at', date('Y'))
        //     ->groupBy(DB::raw('MONTH(joined_at)'))
        //     ->pluck('total', 'month')
        //     ->toArray();
        $totalCustomers = Customer::count();
        $totalDepositC = Deposit::getTotalDepositSukarela();
        $formattedTotalDeposit = Deposit::formatNumber($totalDepositC);
        $Loan = Loan::getLoanBalance();
        $formatLoan = Loan::formatNumber($Loan);
        $diff = DB::table('loans')
        ->selectRaw('SUM(amount - paid) as diff')
        ->value('diff');

        // Mengambil total pinjaman berdasarkan bulan
        $totalLoans = DB::table('loans')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amount) as total'))
        ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month')
            ->toArray();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $customerData = [];
        $loansData = [];

        foreach ($months as $month) {
            if (isset($totalCustomers[$month])) {
                $customerData[] = $totalCustomers[$month];
            } else {
                $customerData[] = null;
            }

            if (isset($totalLoans[$month])) {
                $loansData[] = $totalLoans[$month];
            } else {
                $loansData[] = null;
            }
        }

        // Mengambil data pinjaman terakhir akun yang login
        $user = auth()->user();
        $latestLoan = Loan::where('customer_id', $user->customer_id)
        ->latest('created_at')
        ->first();

        $currentYear = date('Y');
        $totalDepositPokok = Deposit::where('type', 'pokok')
        ->whereYear('created_at', $currentYear)
            ->sum('amount');
        $totalDepositWajib = Deposit::where('type', 'wajib')
        ->whereYear('created_at', $currentYear)
            ->sum('amount');
        $totalDepositSukarela = Deposit::where('type', 'wajib')
        ->whereYear('created_at', $currentYear)
            ->sum('amount');
        $totalDepositPenarikan = Deposit::where('type', 'penarikan')
        ->whereMonth('created_at', $currentYear)
            ->sum('amount');

        return view('pages.dashboard', [
            'title' => 'Dashboard',
            'totalCustomers' => $totalCustomers,
            'totalPinjaman' => $totalLoans,
            'totalDepositPokok' => $totalDepositPokok,
            'totalDepositWajib' => $totalDepositWajib,
            'totalDepositSukarela' => $totalDepositSukarela,
            'totalDepositPenarikan' => $totalDepositPenarikan,
            'customerData' => $customerData,
            'loansData' => $loansData,
            'loanMonths' => $months,
            'latestLoan' => $latestLoan, // Menambahkan data pinjaman terakhir akun yang login
            
            'totalDepositC' => $formattedTotalDeposit,  
            'totalLoan' => $formatLoan,
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