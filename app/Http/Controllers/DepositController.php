<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepositRequest;
use App\Http\Requests\UpdateDepositRequest;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\User;
use App\Traits\LoanTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DepositController extends Controller
{

    use LoanTrait;

    public function __construct()
    {
        $this->title = 'Transaksi - Simpanan';
        $this->code = 'SI';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Deposit::with(['customer', 'loan'])->whereNot('type', 'penarikan')->orderBy('created_at');

            if ($request->customer) {
                $data = $data->where('customer_id', $request->customer);
            }

            if ($request->type) {
                $data = $data->where('type', $request->type);
            }

            if ($request->from) {
                $data = $data->whereDate('created_at', '>=', $request->from);
            }

            if ($request->to) {
                $data = $data->whereDate('created_at', '<=', $request->to);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->customer) {
                        return '<a href="' . route('transaction.deposit.show', $row) . '" class="btn btn-success btn-xs px-2"> Detail </a>
                                <a href="' . route('transaction.deposit.edit', $row) . '" class="btn btn-primary btn-xs px-2 mx-1"> Edit </a>
                                <form class="d-inline" method="POST" action="' . route('transaction.deposit.destroy', $row) . '">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                                </form>';
                    }

                    return '<form class="d-inline" method="POST" action="' . route('transaction.deposit.destroy', $row) . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '" />
                        <button type="submit" class="btn btn-danger btn-xs px-2 delete-data"> Hapus </button>
                    </form>';
                })
                ->editColumn('id', function($row) {
                    return $this->buildTransactionCode($row->id);
                })
                ->editColumn('created_at', function($row) {
                    return Carbon::parse($row->created_at)->isoFormat('DD-MM-Y');
                })
                ->editColumn('type', function($row) {
                    return ucfirst($row->type);
                })
                ->editColumn('customer', function($row) {
                    if ($row->customer) {
                        return $row->customer->name . '<small class="small d-block">No. Rek: ' . $row->customer->number . '</small>';
                    }

                    return 'Nasabah Tidak Ditemukan';
                })
                ->editColumn('amount', function($row) {
                    return 'Rp' . number_format($row->amount, 2, ',', '.');
                })
                ->editColumn('current_balance', function($row) {
                    return 'Rp' . number_format($row->current_balance, 2, ',', '.');
                })
                ->rawColumns(['action', 'customer'])
                ->make(true);
        }
        return view('pages.transaction.deposit.index', [
            'title' => $this->title,
            'customers' => Customer::all(),
            'types' => ['sukarela', 'wajib', 'pokok']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.transaction.deposit.create', [
            'title' => $this->buildTitle('baru'),
            'customers' => Customer::where('status', 'active')->get(),
            'types' => ['sukarela', 'wajib']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepositRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepositRequest $request)
    {
        try {
            DB::beginTransaction();
            $simpanan = Deposit::where('customer_id', $request->customer_id)->latest()->first();
            $data = $request->all();
            $data['previous_balance'] = $simpanan->current_balance ?? 0;
            $data['current_balance'] = $data['previous_balance'] + $request->amount;
            Deposit::create($data);
            if ($simpanan && $request->type == 'wajib' && $request->loan_id) {
                $this->paidLoan($request->loan_id);
            }
            DB::commit();
            return redirect()->route('transaction.deposit.index')->with('success', 'Berhasil menambahkan simpanan nasabah!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deposit  $simpanan
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit $simpanan)
    {
        return view('pages.transaction.deposit.show', [
            'title' => $this->buildTitle('detail'),
            'deposit' => $simpanan,
            'code' => $this->buildTransactionCode($simpanan->id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deposit  $simpanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit $simpanan)
    {
        return view('pages.transaction.deposit.edit', [
            'title' => $this->buildTitle('edit'),
            'types' => ['sukarela', 'wajib', 'pokok'],
            'code' => $this->buildTransactionCode($simpanan->id),
            'deposit' => $simpanan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepositRequest  $request
     * @param  \App\Models\Deposit  $simpanan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepositRequest $request, Deposit $simpanan)
    {
        try {
            DB::beginTransaction();
            $simpanan->update($request->all());
            if ($simpanan && $request->type == 'wajib' && $request->loan_id) {
                $this->paidLoan($request->loan_id);
            }
            DB::commit();
            return back()->with('success', 'Berhasil mengedit simpanan nasabah!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deposit  $simpanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $simpanan)
    {
        try {
            DB::beginTransaction();
            $type = $simpanan->type;
            $id = $simpanan->loan_id;
            $simpanan->delete();
            if ($type == 'wajib' && $id) {
                $this->paidLoan($id);
            }
            DB::commit();
            return back()->with('success', 'Berhasil menghapus simpanan nasabah!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function print(Request $request)
    {
        $customer = Customer::find($request->customer_id);

        $data = Deposit::selectRaw("customer_id, DATE(created_at) as tanggal, SUM(CASE WHEN type='pokok' THEN amount ELSE 0 END) as pokok, SUM(CASE WHEN type='sukarela' THEN amount ELSE 0 END) as sukarela, SUM(CASE WHEN type='wajib' THEN amount ELSE 0 END) as wajib, SUM(CASE WHEN type='pokok' THEN amount ELSE 0 END) + SUM(CASE WHEN type='sukarela' THEN amount ELSE 0 END) + SUM(CASE WHEN type='wajib' THEN amount ELSE 0 END) AS saldo")
            ->where('customer_id', $request->customer_id)
            ->groupByRaw('customer_id, DATE(created_at)')
            ->orderByRaw('DATE(created_at) ASC')
            ->get();
        $manager = User::where('role', 'manager')->first();
        $filename = Carbon::now()->isoFormat('DD-MM-Y') . '_-_laporan_simpanan_nasabah_no_rekening_' . $customer->number  . '_' . time() . '.pdf';

        $pdf = PDF::loadView('pages.transaction.deposit.print', [
            'title' => 'Laporan Simpanan Nasabah',
            'user' => auth()->user(),
            'customer' => $customer,
            'date' => Carbon::now()->isoFormat('dddd, D MMMM Y'),
            'manager' => $manager,
            'data' => $data,
            'total' => 0
        ]);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($filename);
    }
}
