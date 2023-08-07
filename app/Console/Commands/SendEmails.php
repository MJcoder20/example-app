<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Vendor;
use App\Support\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowItemQuantityNotification;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {--vendor}{item*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Request a new quantity from vendor';

    
    public function handle(): void
    {
        $items = $this->argument('item');
        $v = $this->option('vendor');
        foreach($items as $i){
            $item = DB::table('items')->where('name',$i)->first();
            $item = Item::find(collect($item)->get('id'));
            if($item!=null){
                if($v==null ){
                    $vendors = DB::table('vendor_items')->where('item_id','=',$item->id)->pluck('vendor_id');
                    foreach($vendors as $vendor){
                        Mail::to(Vendor::find($vendor->vendor_id))
                        ->queue(new LowItemQuantityNotification($item));
                    }
                }else{
                    Mail::to($v)
                        ->queue(new LowItemQuantityNotification($item));
                }
            }
            
        }
        
        $this->info('Emails sent successfully! ');
    }
}
