<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function collateral()
    {
        return $this->belongsTo(Collateral::class, 'collateral_id', 'id');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }
    public static function getLoanBalance()
    {
        $totalAmount = self::sum('amount'); // Menghitung total amount dari seluruh loan
        $totalPaid = self::sum('paid'); // Menghitung total paid dari seluruh loan
        $balance = $totalAmount - $totalPaid; // Menghitung selisih antara amount dan paid

        return $balance;
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