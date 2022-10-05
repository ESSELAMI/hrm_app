<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use App\Models\Vehicle;

class VehicleControlExpired extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $deadline;
    public function __construct(Vehicle $vehicle)
    {
         $this->vehicle = $vehicle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($this->vehicle->technicalControls->count() == 0 ) {
            $message = "Manque d'informations sur le controle technique!";
            $deadline = "";
        } else{
            $current_date = Carbon::now();
            $endsAt =  Carbon::parse($this->vehicle->latestTechnicalControl->ends_at);
            $message = "Date du vignette : ".$endsAt->format('d/m/Y');
            $days = $endsAt->diffInDays($current_date, false);
            $message = "Date du controle technique : ".Carbon::parse($this->vehicle->latestTechnicalControl->ends_at)->format('d/m/Y');
            $days = $current_date->diffInDays(Carbon::parse($this->vehicle->latestTechnicalControl->ends_at), false);
            if ($days < 0) {
                $deadline = "Délai du control a expiré il y a ".sprintf("%02d", abs($days))." Jour (s)";
            } else if ($days > 0) {
                $deadline = "Il reste ".sprintf("%02d", abs($days))." Jour (s)";
            } else if($days==0){
                $deadline = "Dernier délai du controle est aujourd'hui ";
            }               
                                            
        }

        return [
            "message" => $message,
            "deadline" => $deadline,
            "vehicle" => $this->vehicle
        ];
    }
}
