<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientNotificationAdmin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($typeSent,$userid,$email,$names,$phone,$movie_id,$movie_name,$screen_id,$screen_name,$upcoming,$seat_id,$seat_name,$section,$ticket_amount,$start_date,$end_date,$ticket_id,$thisticket,$status,$wallet,$sold_on,$used_on,$description)
    {
        $this->typeSent=$typeSent;
        $this->userid=$userid;
        $this->email=$email;
        $this->names=$names;
        $this->phone=$phone;
        $this->movie_id=$movie_id;
        $this->movie_name=$movie_name;
        $this->screen_id=$screen_id;
        $this->screen_name=$screen_name;
        $this->upcoming=$upcoming;
        $this->seat_id=$seat_id;
        $this->seat_name=$seat_name;
        $this->section=$section;
        $this->ticket_amount=$ticket_amount;
        $this->start_date=$start_date;
        $this->end_date=$end_date;
        $this->ticket_id=$ticket_id;
        $this->thisticket=$thisticket;
        $this->status=$status;
        $this->wallet=$wallet;
        $this->sold_on=$sold_on;
        $this->used_on=$used_on;
        $this->description=$description;
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
    // public function toMail($notifiable)
    // {
    //     if ($this->typeSent=='New Client') {
    //         return (new MailMessage)
    //             ->line('New Client '.$this->names.'.')
    //             ->line('Has just Created New Account, With Email '.$this->email.'.')
    //             ->action('Login Here', url('/home'))
    //             ->line('For more Information, please write or call our Support Team!')
    //             ->line('Thank you for trusting our Services!');
    //     }

    //     else if ($this->typeSent=='Movie Request') {
    //         return (new MailMessage)
    //             ->line('Client '.$this->names.'.')
    //             ->line('Has Requested for Movie.')
    //             ->line('Please Login to View Details.')
    //             ->action('Login Here', url('/home'))
    //             ->line('For more Information, please write or call our Support Team!')
    //             ->line('Thank you for trusting our Services!');
    //     }

    //     else if ($this->typeSent=='Movie Request Response') {
    //         return (new MailMessage)
    //             ->line('Client '.$this->names.'.')
    //             ->line('Movie Request has been Procceded.')
    //             ->line('Please Login to View more Details.')
    //             ->action('Login Here', url('/home'))
    //             ->line('For more Information, please write to or call our Support Team!')
    //             ->line('Thank you for trusting our Services!');
    //     }

    //     else if ($this->typeSent=='Refund Request') {
    //         return (new MailMessage)
    //             ->line('Client '.$this->names.'.')
    //             ->line('Has Requested for Refund.')
    //             ->line('Please Login to View Details.')
    //             ->action('Login Here', url('/home'))
    //             ->line('For more Information, please write or call our Support Team!')
    //             ->line('Thank you for trusting our Services!');
    //     }

    //     else if ($this->typeSent=='Refund Request Response') {
    //         return (new MailMessage)
    //             ->line('Client '.$this->names.'.')
    //             ->line('Refund Request has been Procceded.')
    //             ->line('Please Login to View more Details.')
    //             ->action('Login Here', url('/home'))
    //             ->line('For more Information, please write to or call our Support Team!')
    //             ->line('Thank you for trusting our Services!');
    //     }

    //     else if ($this->typeSent=='Booked') {
    //         return (new MailMessage)
    //             ->line('Client '.$this->names.'.')
    //             ->line('Booked for Seat '.$this->seat_name.'.('.$this->section.')')
    //             ->line('Movie :  '.$this->movie_name.'.')
    //             ->line('On Screen : '.$this->screen_name.'.')
    //             ->line('Amount : '.$this->ticket_amount.'.')
    //             ->line('Starting On: '.$this->start_date.'.')
    //             ->line('Ending On: '.$this->end_date.'.')
    //             ->line('Login to View Details.')
    //             ->action('Login Here', url('/home'))
    //             ->line('For more Information, please write or call our Support Team!')
    //             ->line('Thank you for trusting our Services!');
    //     }

    //     else if ($this->typeSent=='Reserved') {
    //         return (new MailMessage)
    //             ->line('Client '.$this->names.'.')
    //             ->line('Reserved Seat.')
    //             ->line('Payment for Seat '.$this->seat_name.'.('.$this->section.') with Ticket: '.$this->thisticket.' Was Succesful.')
    //             ->line('Movie :  '.$this->movie_name.'.')
    //             ->line('On Screen : '.$this->screen_name.'.')
    //             ->line('Amount : '.$this->ticket_amount.'.')
    //             ->line('Starting On: '.$this->start_date.'.')
    //             ->line('Ending On: '.$this->end_date.'.')
    //             ->line('Placed On: '.$this->sold_on.'.')
    //             ->line('Login to View Details.')
    //             ->action('Login Here', url('/home'))
    //             ->line('For more Information, please write or call our Support Team!')
    //             ->line('Thank you for trusting our Services!');
    //     }

    //     else if ($this->typeSent=='Checked In') {
    //         return (new MailMessage)
    //             ->line('Client '.$this->names.'.')
    //             ->line('Has just Checked In.')
    //             ->line('Ticket: '.$this->thisticket.'.')
    //             ->line('Movie :  '.$this->movie_name.'.')
    //             ->line('On Screen : '.$this->screen_name.'.')
    //             ->line('Amount : '.$this->ticket_amount.'.')
    //             ->line('Starting On: '.$this->start_date.'.')
    //             ->line('Ending On: '.$this->end_date.'.')
    //             ->line('Placed On: '.$this->sold_on.'.')
    //             ->line('Login to Accept Check In.')
    //             ->action('Login Here', url('/home'))
    //             ->line('For more Information, please write or call our Support Team!')
    //             ->line('Thank you for trusting our Services!');
    //     }

    //     else if ($this->typeSent=='Canceled') {
    //         return (new MailMessage)
    //             ->line('Client '.$this->names.'.')
    //             ->line('Has just Canceled a Ticket.')
    //             ->line('Ticket: '.$this->thisticket.'.')
    //             ->line('Movie :  '.$this->movie_name.'.')
    //             ->line('On Screen : '.$this->screen_name.'.')
    //             ->line('Amount : '.$this->ticket_amount.'.')
    //             ->line('Starting On: '.$this->start_date.'.')
    //             ->line('Ending On: '.$this->end_date.'.')
    //             ->line('Placed On: '.$this->sold_on.'.')
    //             ->action('Login Here', url('/home'))
    //             ->line('For more Information, please write or call our Support Team!')
    //             ->line('Thank you for trusting our Services!');
    //     }

    //     else if ($this->typeSent=='Checked In Accepted') {
    //         return (new MailMessage)
    //             ->line('Client '.$this->names.'.')
    //             ->line('You Just Accepted Checked In.')
    //             ->line('Ticket: '.$this->thisticket.'.')
    //             ->line('Movie :  '.$this->movie_name.'.')
    //             ->line('On Screen : '.$this->screen_name.'.')
    //             ->line('Amount : '.$this->ticket_amount.'.')
    //             ->line('Starting On: '.$this->start_date.'.')
    //             ->line('Ending On: '.$this->end_date.'.')
    //             ->line('Placed On: '.$this->sold_on.'.')
    //             ->action('Login Here', url('/home'))
    //             ->line('For more Information, please write or call our Support Team!')
    //             ->line('Thank you for trusting our Services!');
    //     }
    // }

    public function toDatabase($notifiable)
    {
        if ($this->typeSent=='New Client' || $this->typeSent=='Movie Request' || $this->typeSent=='Movie Request Response' || $this->typeSent=='Refund Request' || $this->typeSent=='Refund Request Response') {
            return [
                'typeSent'=>$this->typeSent,
                'userid'=>$this->userid,
                'description'=>$this->description,
            ];
        }

        else if ($this->typeSent=='Booked' || $this->typeSent=='Reserved' || $this->typeSent=='Checked In' || $this->typeSent=='Checked In Accepted' || $this->typeSent=='Canceled') {
            return [
                'typeSent'=>$this->typeSent,
                'userid'=>$this->userid,
                'phone'=>$this->phone,
                'names'=>$this->names,
                'movie_id'=>$this->movie_id,
                'movie_name'=>$this->movie_name,
                'screen_name'=>$this->screen_name,
                'screen_id'=>$this->screen_id,
                'upcoming'=>$this->upcoming,
                'seat_id'=>$this->seat_id,
                'seat_name'=>$this->seat_name,
                'section'=>$this->section,
                'ticket_amount'=>$this->ticket_amount,
                'start_date'=>$this->start_date,
                'end_date'=>$this->end_date,
                'ticket_id'=>$this->ticket_id,
                'thisticket'=>$this->thisticket,
                'status'=>$this->status,
                'wallet'=>$this->wallet,
                'sold_on'=>$this->sold_on,
                'used_on'=>$this->used_on,
                'description'=>$this->description,
            ];
        }
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