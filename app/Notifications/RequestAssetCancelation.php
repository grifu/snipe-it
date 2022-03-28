<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class RequestAssetCancelationNotification extends Notification
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
        $this->note = '';
        $this->last_checkout = '';
        $this->item_quantity = $params['item_quantity'];
        $this->expected_checkin = '';
        $this->requested_date = \App\Helpers\Helper::getFormattedDateObject($params['requested_date'], 'datetime',
            false);
        
        $this->settings = Setting::getSettings();

        if (array_key_exists('note', $params)) {
            $this->note = $params['note'];
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
        $item = $this->item;
        $note = $this->note;
        $qty = $this->item_quantity;
        
        $botname = ($this->settings->slack_botname) ? $this->settings->slack_botname : 'Snipe-Bot' ;

        $fields = [
            'QTY' => $qty,
            'Canceled By' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
        ];

        if (($this->expected_checkin) && ($this->expected_checkin!='')) {
            $fields['Expected Checkin'] = $this->expected_checkin;
        }

        return (new SlackMessage)
            ->content( trans('mail.a_user_canceled'))
            ->from($botname)
            ->attachment(function ($attachment) use ($item, $note, $fields) {
                $attachment->title(htmlspecialchars_decode($item->present()->name), $item->present()->viewUrl())
                    ->fields($fields)
                    ->content($note);
            });
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

     
    public function toMail($notifiable)
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
                'requested_by'  => $this->target,
                'requested_date' => $this->requested_date,
                'fields'        => $fields,
                'qty'           => $this->item_quantity,
                'last_checkout' => $this->last_checkout,
                'expected_checkin'  => $this->expected_checkin,
                'intro_text'        => trans('mail.a_user_canceled'),
            ])
            ->subject(trans('Item Request Canceled'));


        return $message;


    }

}
