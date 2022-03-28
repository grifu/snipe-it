<?php

namespace App\Notifications;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckoutAssetNotification extends Notification
{
    use Queueable;
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
        $this->admin = $params['admin'];
        $this->log_id = $params['log_id'];
        $this->note = '';
        $this->last_checkout = '';
        $this->expected_checkin = '';
        $this->target_type = $params['target_type'];
        $this->settings = $params['settings'];

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

        /**
         * Only send notifications to users that have email addresses
         */
        if ($this->target instanceof User && $this->target->email != '') {

            /**
             * Send an email if the asset requires acceptance, 
             * so the user can accept or decline the asset
             */
            if ($this->item->requireAcceptance()) {
                $notifyBy[1] = 'mail';
            }

            /**
             * Send an email if the item has a EULA, since the user should always receive it
             */
            if ($this->item->getEula()) {
                $notifyBy[1] = 'mail';
            }            

            /**
             * Send an email if an email should be sent at checkin/checkout
             */
            if ($this->item->checkin_email()) {
                $notifyBy[1] = 'mail';
            }            

        }

        return $notifyBy;
    }

    public function toSlack()
    {

        $target = $this->target;
        $admin = $this->admin;
        $item = $this->item;
        $note = $this->note;
        $botname = ($this->settings->slack_botname) ? $this->settings->slack_botname : 'Snipe-Bot' ;

        $fields = [
            'To' => '<'.$target->present()->viewUrl().'|'.$target->present()->fullName().'>',
            'By' => '<'.$admin->present()->viewUrl().'|'.$admin->present()->fullName().'>',
        ];

        if (($this->expected_checkin) && ($this->expected_checkin!='')) {
            $fields['Expected Checkin'] = $this->expected_checkin;
        }

        return (new SlackMessage)
            ->content(':arrow_up: :computer: Asset Checked Out')
            ->from($botname)
            ->attachment(function ($attachment) use ($item, $note, $admin, $fields) {
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
    public function toMail()
    {

        $eula =  method_exists($this->item, 'getEula') ? $this->item->getEula() : '';
        $req_accept = method_exists($this->item, 'requireAcceptance') ? $this->item->requireAcceptance() : 0;

        $fields = [];

        // Check if the item has custom fields associated with it
        if (($this->item->model) && ($this->item->model->fieldset)) {
            $fields = $this->item->model->fieldset->fields;
        }

        $message = (new MailMessage)->markdown('notifications.markdown.checkout-asset',
            [
                'item'          => $this->item,
                'admin'         => $this->admin,
                'note'          => $this->note,
                'log_id'        => $this->note,
                'target'        => $this->target,
                'fields'        => $fields,
                'eula'          => $eula,
                'req_accept'    => $req_accept,
                'accept_url'    =>  url('/').'/account/accept-asset/'.$this->log_id,
                'last_checkout' => $this->last_checkout,
                'expected_checkin'  => $this->expected_checkin,
            ])
            ->subject(trans('mail.Confirm_asset_delivery'));


        return $message;


    }

}
