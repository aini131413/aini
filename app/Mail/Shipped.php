<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Shipped extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order=$order;
//        dump($order);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        dump($this->order);exit;
        return $this
            ->from("36054222@qq.com")
            ->view('mail.win',["order"=>$this->order]);
    }
}
