<?php

namespace PlaceToPay\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PlaceToPay\Http\Controllers\PlaceToPay\Soap;
use PlaceToPay\Transaction;

class SondaPlaceToPay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $soap;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Soap $soap)
    {
        //
        $this->soap = $soap;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Transaction $transaction)
    {
        //
        $result = $transaction->where('status' , 'PENDING')->get(["transaction_id","status"]);
        foreach ($result as $value) {
             $transaction = $value->transaction_id;
             $result = $this->soap->getTransactionInformation($transaction);
             if ( $result && $result->getTransactionInformationResult ) {
               if ( $result->getTransactionInformationResult->transactionState != $value->status) {
                    $value->status = $result->getTransactionInformationResult->transactionState;
                    $value->save();
               }
             }
        }
        // $transaction
    }
}
