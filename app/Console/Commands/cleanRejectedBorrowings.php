<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrowing;

class CleanRejectedBorrowings extends Command
{
    protected $signature = 'clean:rejected-borrowings';
    protected $description = 'Delete rejected borrowings after 24 hours';

    public function handle()
    {
        Borrowing::where('status','rejected')
            ->where('updated_at','<=', now()->subDay())
            ->delete();

        $this->info('Old rejected borrowings deleted.');
    }
}