<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pro)
    {
        //
        $this->pro = $pro;
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
        $subject = "PRO Notification";
        $line1= "A PRO Process requires your attention";
        $line2= "Act now, stay on top of things! ...Its the mofad way";
        $url = "http://app.mofadenergysolutions.com/";
        if($this->pro->current_approval=="l0"){
            $subject  = " New PRO created by ". $this->pro->createdBy->name;
        }
        elseif($this->pro->current_approval == $this->pro->final_approval){
            $subject  = "PRO ".$this->pro->id." Approved ";
        }
        elseif($this->pro->current_approval=="l1"){
            $line1= "PRO ".$this->pro->id." has been approved by ". $this->pro->approvedBy('l1');
        }
        elseif($this->pro->current_approval=="l2"){
            $subject  = "PRO <a>".$this->pro->id."</a> Approved for collection. Recipient: ". $this->pro->createdBy->name;
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
