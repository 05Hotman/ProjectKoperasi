<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deposit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    // Fungsi untuk mengambil total deposit keseluruhan
    public static function getTotalDepositSukarela()
    {
        return self::select('current_balance')
        ->whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('deposits')
                ->groupBy('customer_id');
        })
        ->where('type', 'sukarela')
            ->sum('current_balance');
    }
    public static function getTotalDepositWajib()
    {
        return self::select('current_balance')
        ->whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
            ->from('deposits')
            ->groupBy('customer_id');
        })
            ->where('type', 'wajib')
            ->sum('current_balance');
    }


    // Fungsi untuk mengubah format angka menjadi "k", "m", atau "B"
    public static function formatNumber($number)
    {
        $suffix = '';
        if ($number >= 1000 && $number < 1000000) {
            $number = $number / 1000;
            $suffix = 'k';
        } elseif ($number >= 1000000 && $number < 1000000000) {
            $number = $number / 1000000;
            $suffix = 'm';
        } elseif ($number >= 1000000000) {
            $number = $number / 1000000000;
            $suffix = 'B';
        } elseif ($number >= 1000000000000) {
            $number = $number / 1000000000000;
            $suffix = 'T';
        }
        return number_format($number, 0, '.', '') . $suffix;
    }
}