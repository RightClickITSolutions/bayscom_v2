<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Illuminate\Support\Facades\Auth;

class PrfNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($prf)
    {
        //
        $this->prf = $prf;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $greeting = "Hello, ";
        $subject = "PRF Notification";
        $line1= "A PRF Process requires your attention";
        $line2= "Act now, stay on top of things! ...Its the mofad way";
        $url = "https://app.mofadenergysolutions.com/";
        if($this->prf->current_approval=="l0"){
            $subject  = " New PRF created by ". $this->prf->createdBy->name;
        }
        elseif($this->prf->current_approval == $this->prf->final_approval){
            $subject  = "PRF ".$this->prf->id." Approved for collection. Recipient: ". $this->prf->createdBy->name;
        }
        elseif($this->prf->current_approval=="l1"){
            $line1= "PRF ".$this->prf->id." has been approved by ". $this->prf->approvedBy('l1');
        }
        
        return (new MailMessage)
                    ->subject($subject)
                    ->line($line1)
                    ->action('Open', url($url))
                    ->line($line2);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
