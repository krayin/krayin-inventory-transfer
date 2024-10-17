<?php

namespace Webkul\InventoryTransfer\Notifications;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Storage;

class Common extends Mailable
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $data) {}

    /**
     * Build the mail representation of the notification.
     */
    public function build()
    {
        $message = $this
            ->to($this->data['to'])
            ->subject($this->data['subject'])
            ->view('admin::emails.common', [
                'name' => $this->data['name'] ?? '',
                'body' => $this->data['body'],
            ]);

        if (isset($this->data['attachments'])) {
            foreach ($this->data['attachments'] as $attachment) {
                if (! empty($attachment['path'])) {
                    $attachment['content'] = Storage::disk('local')->get($attachment['path']);

                    Storage::disk('local')->delete($attachment['path']);
                }

                $message->attachData($attachment['content'], $attachment['name'], [
                    'mime' => $attachment['mime'],
                ]);
            }
        }

        return $message;
    }
}
