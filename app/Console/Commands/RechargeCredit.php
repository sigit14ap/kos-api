<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\User\Interfaces\UserServiceInterface;

class RechargeCredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:recharge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recharge credit for regular and premium user on every start of the month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(UserServiceInterface $service)
    {
        return $service->addCredit();
    }
}
