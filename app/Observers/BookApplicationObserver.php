<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\BookApplication;
use App\Notifications\Book\BookApplicationStatusUpdatedNotification;

final class BookApplicationObserver
{
    /**
     * Handle the BookApplication "updated" event.
     */
    public function updated(BookApplication $book_application): void
    {
        if ($book_application->isDirty(attributes: 'status')) {
            $book_application->user->notify(new BookApplicationStatusUpdatedNotification(book_application: $book_application));
        }
    }
}
