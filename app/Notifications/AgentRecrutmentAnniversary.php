<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Models\Agent;

use Illuminate\Support\Facades\Auth;

class AgentRecrutmentAnniversary extends Notification implements ShouldQueue

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
        if ($this->agent->recrutment_date == "" ) {
            $message = "Manque d'informations sur la date de recrutement!";
            $deadline = "";
        } else{
            $current_date = Carbon::now(); 
            $message = "Anniversaire de recrutement: ".Carbon::parse($this->agent->recrutment_date)->format('d/m/Y');
            $days = $current_date->diffInDays($this->agent->recrutment_date, false);
            if ($days < 0) {
                 $deadline = "Anniversaire de recrutement a expiré il y a ".sprintf("%02d", abs($days))." Jour (s)";
            } else if ($days > 0) {
                $deadline = "Il reste ".sprintf("%02d", abs($days))." Jour (s)";
            } else{
                $deadline = "Anniversaire de recrutement est aujourd'hui ";
            }       
        }       
        return [
            "message" => $message,
            "deadline" => $deadline,
            "agent" => $this->agent
        ];
    }
}
