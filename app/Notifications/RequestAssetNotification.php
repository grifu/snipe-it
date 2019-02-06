<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class RequestAssetNotification extends Notification
{

    
    /**
     * @var
     */
    private $params;

    /**
     * Create a new notification instance.
     *
     * @param $params
     */
    
    public function __construct($params)
    {
        $this->target = $params['target'];
        $this->item = $params['item'];
        $this->item_type = $params['item_type'];
        $this->item_quantity = $params['item_quantity'];
        $this->responsible = '';
        $this->note = '';
        $this->check_out = '';
        $this->check_in = '';
        $this->url_aproval = url('/invoice/');
        $this->last_checkout = '';
        $this->expected_checkin = '';
        $this->requested_date = \App\Helpers\Helper::getFormattedDateObject($params['requested_date'], 'datetime',
            false);
        $this->settings = Setting::getSettings();


        if (array_key_exists('destination', $params)) {
            $this->destination = $params['destination'];
            routeNotificationForMail($this->destination);

        }
        

        if (array_key_exists('note', $params)) {
            $this->note = $params['note'];
        }

        if (array_key_exists('responsible', $params)) {
            $this->responsible = $params['responsible'];
        }
        if (array_key_exists('check_out', $params)) {
            $this->check_out = $params['check_out'];
        }
        if (array_key_exists('check_in', $params)) {
            $this->check_in = $params['check_in'];
        }

        if ($this->item->last_checkout) {
            $this->last_checkout = \App\Helpers\Helper::getFormattedDateObject($this->item->last_checkout, 'date',
                false);
        }

        if ($this->item->expected_checkin) {
            $this->expected_checkin = \App\Helpers\Helper::getFormattedDateObject($this->item->expected_checkin, 'date',
                false);
        }



    }



    /**
     * Route notifications for the mail channel.
     * GRIFU
     * https://laravel.com/docs/5.7/notifications
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->destination;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
    {

        $notifyBy = [];

        if (Setting::getSettings()->slack_endpoint!='') {
            \Log::debug('use slack');
            $notifyBy[] = 'slack';
        }


        $notifyBy[] = 'mail';

        return $notifyBy;
    }


    
    public function toSlack()
    {
        $target = $this->target;
        $qty = $this->item_quantity;
        $item = $this->item;
        $note = $this->note;
        $fieldset = $this->fieldset;
        $check_out = $this->check_out;
        $check_in = $this->check_in;
        $responsible = $this->responsible;
        $botname = ($this->settings->slack_botname) ? $this->settings->slack_botname : 'Snipe-Bot' ;

        $fields = [
            'QTY' => $qty,
            'Requested By' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
        ];

        //GRIFU


        return (new SlackMessage)
            ->content(trans('mail.Item_Requested'))
            ->cc(['luisleite@esmad.ipp.pt'])
            ->from($botname)
            ->attachment(function ($attachment) use ($item, $note, $fields, $responsible, $check_in, $check_out) {
                $attachment->title(htmlspecialchars_decode($item->present()->name), $item->present()->viewUrl())
                    ->fields($fields)
                    ->content($check_in)
                    ->content($check_out)
                    ->content($responsible)
                    ->content($note);
            });
    }




    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    
    public function toMail()
    {



        $fields = [];

        // Check if the item has custom fields associated with it
        if (($this->item->model) && ($this->item->model->fieldset)) {
            $fields = $this->item->model->fieldset->fields;
        }

        
        
        $message = (new MailMessage)->markdown('notifications.markdown.asset-requested',
            [
                'item'          => $this->item,
                'note'          => $this->note,
                'responsible'   => $this->responsible,
                'requested_by'  => $this->target,
                'requested_date' => $this->requested_date,
                'fields'        => $fields,
                'last_checkout' => $this->last_checkout,
                'expected_checkin'  => $this->expected_checkin,
                'check_in'     => $this->check_in,
                'check_out'     => $this->check_out,
                'url_aproval'   => $this->url_aproval,
                'intro_text'        => trans('mail.a_user_requested'),
                'qty'           => $this->item_quantity,
            ])
            ->subject(trans('mail.Item_Requested'));


    
        return $message;


    }

}
