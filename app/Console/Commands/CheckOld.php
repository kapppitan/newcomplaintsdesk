<?php

namespace App\Console\Commands;

use App\Models\Complaints;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckOld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threeDaysAgo = Carbon::now()->subDays(3);

        $expiredRecords = Complaints::where('status', 'Non-Conforming')->where('updated_at', '=>', $threeDaysAgo)->get();

        foreach ($expiredRecords as $record) {
            $record->status = 'Disregard';
            $record->save();
        }
    }
}
