<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CleanupSoftDeletedUsers extends Command
{
    protected $signature = 'cleanup:users';

    protected $description = 'Force delete users soft deleted after 7 days';

    public function handle()
    {
        $expireDate = Carbon::now()->subDays(7);

        User::onlyTrashed()
            ->where('deleted_at', '<=', $expireDate)
            ->forceDelete();

        return Command::SUCCESS;
    }
}
