<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Models\Agent;

use Illuminate\Support\Facades\Auth;

class AgentConfirmedLevel extends Notification implements ShouldQueue

{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $agent;
    public function __construct(Agent $agent)
    {
        $this->agent = $agent;

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
        if ($this->agent->confirmedLevels->count() == 0 ) {
            $message = "Manque d'informations sur l'échelon!";
            $deadline = "";
        } else{
            $current_date = Carbon::now();
            $next_at =  Carbon::parse($this->agent->latestConfirmedLevel->next_at);
            $message = "Date mise à jour de l'échelon : ".$next_at->format('d/m/Y');
            $days = $next_at->diffInDays($current_date, false);
            $message = "Date mise à jour de l'échelon : ".Carbon::parse($this->agent->latestConfirmedLevel->next_at)->format('d/m/Y');
            $days = $current_date->diffInDays(Carbon::parse($this->agent->latestConfirmedLevel->next_at), false);
            if ($days < 0) {
                $deadline = "Délai de mise à jour de l'échelon a expiré il y a ".sprintf("%02d", abs($days))." Jour (s)";
            } else if ($days > 0) {
                $deadline = "Il reste ".sprintf("%02d", abs($days))." Jour (s)";
            } else if($days==0){
                $deadline = "Dernier délai de mise à jour de l'échelon est aujourd'hui ";
            }               
                                            
        }   
        return [
            "message" => $message,
            "deadline" => $deadline,
            "agent" => $this->agent
        ];
    }
}
