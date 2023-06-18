<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DepositController;

class saldoperbulankurang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saldoperbulankurang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengurangi saldo simpanan sukarela setiap bulan';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Panggil fungsi processMonthlyVoluntaryDepositReduction()
        (new DepositController)->processMonthlyVoluntaryDepositReduction();

        // Tambahkan logika lain yang Anda butuhkan

        return Command::SUCCESS;
    }
}