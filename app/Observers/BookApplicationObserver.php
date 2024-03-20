<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\BookApplicationStatusEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookApplication;
use App\Models\BookUser;
use App\Notifications\Book\BookApplicationStatusUpdatedNotification;
use Illuminate\Support\Facades\Log;

final class BookApplicationObserver
{
    /**
     * Handle the BookApplication "updated" event.
     */
    public function updated(BookApplication $book_application): void
    {
        if ($book_application->isDirty(attributes: 'status')) {
            Log::info(print_r($book_application->status, true));
            if ($book_application->status === BookApplicationStatusEnum::Approved) {
                $author_id = $book_application->author_id;

                if (!$author_id) {
                    /** @var Author $author */
                    $author = Author::query()->create(attributes: [
                        'name' => $book_application->author_name,
                    ]);

                    $author_id = $author->id;
                }

                /** @var Book $book */
                $book = Book::query()->create(attributes: [
                    'author_id' => $author_id,
                    'category_id' => $book_application->category_id,
                    'title' => $book_application->title,
                    'description' => $book_application->description,
                ]);

                BookUser::query()->create(attributes: [
                    'book_id' => $book->id,
                    'user_id' => $book_application->user_id,
                ]);
            }

            $book_application->user->notify(new BookApplicationStatusUpdatedNotification(book_application: $book_application));
        }
    }
}
