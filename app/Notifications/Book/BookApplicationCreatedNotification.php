<?php

declare(strict_types=1);

namespace App\Notifications\Book;

use App\Models\BookApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class BookApplicationCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public BookApplication $book_application)
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Your book application has been received!'))
            ->line(__('Hello').' '.$this->book_application->user->name.',')
            ->line(__('We have received your book application. We will review it and get back to you soon.'))
            ->line(__('If you have any questions, feel free to contact us.'))
            ->line(__('Thank you for taking care of our planet!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
