<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestSellerDelete extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $seller;

    public function __construct($seller)
    {
        $this->seller = $seller;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

     public function build()
     {
        $seller_id = $this->seller->id;
        $seller_reason = $this->seller->reason_for_delete;
     
        return $this->subject(translate('Request to deactivate seller account'))
                     ->view('email-templates.request_seller_dlt', ['seller_id' => $seller_id, 'seller_reason' => $seller_reason]);
     }
     
}
