<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewProductsNewsLetter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $products;
    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
   public function envelope()
   {
       return new Envelope(
           subject: 'New Products News Letter',
       );
   }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
   public function content()
   {
    //    return new Content(
    //        view: 'mails.products-newsletter',
    //    );
   }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
//    public function attachments()
//    {
//        return [];
//    }


      public function build()
      {
        $this->subject('latest listing');
        $this->from('newletter@example.com' , config('app.name'));
          return $this->view('mails.products-newsletter' , [
              'products'=>$this->products,
          ]);
      }
}