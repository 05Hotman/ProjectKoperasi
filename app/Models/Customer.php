<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function updateTotalPokok()
    {
        $total = $this->deposits()->where('type', 'pokok')->sum('amount');
        $this->total_pokok = $total;
        $this->save();

        $currentStatus = $this->status; // Menyimpan status saat ini sebelum melakukan perubahan

        if ($total > 100000 && $currentStatus !== 'active') {
            $this->status = 'active'; // Mengubah status menjadi "active" jika total deposit pokok melebihi 100000 dan status bukan "active"
        } elseif ($total <= 100000 && $currentStatus !== 'nonactive') {
            $this->status = 'nonactive'; // Mengubah status menjadi "nonactive" jika total deposit pokok tidak melebihi 100000 dan status bukan "nonactive"
        }

        // Hanya menyimpan perubahan status jika ada perubahan yang dilakukan
        if ($this->status !== $currentStatus) {
            $this->save();
        }
    }



    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function collaterals()
    {
        return $this->hasMany(Collateral::class);
    }

    public function foreclosures()
    {
        return $this->hasMany(Foreclosure::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
}