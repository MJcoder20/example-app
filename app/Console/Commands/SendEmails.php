<?php

namespace App\Console\Commands;

use App\Models\Vendor;
use App\Support\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowItemQuantityNotification;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {vendor}{item?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Request a new quantity from vendor';

    
    public function handle(): void
    {

        $vendor = $this->argument('vendor');
       
        Mail::to(Vendor::find($vendor)->email)
            ->queue(new LowItemQuantityNotification());
        
        
        $this->info('Emails sent successfully! ');
    }
}
