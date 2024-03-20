<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Book;

use App\Models\BookApplication;
use App\Models\User;
use App\Notifications\Book\BookApplicationCreatedNotification;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Src\Book\Application\UseCases\CreateBookApplicationUseCase;
use Src\Book\Application\UseCases\ListBooksUseCase;

final class BookApiService
{
    public function __construct(
        private readonly ListBooksUseCase $list_books_use_case,
        private readonly CreateBookApplicationUseCase $create_book_application_use_case
    )
    {}

    /**
     * List books
     *
     * @param array $data
     * @return Paginator
     */
    public function listBooks(array $data): Paginator
    {
        $filters = [];
        $per_page = null;

        if (isset($data['results']) && is_numeric($data['results'])) {
            $per_page = (int)$data['results'];
        }

        if (isset($data['title'])) {
            $filters['title'] = $data['title'];
        }

        if (isset($data['author'])) {
            $filters['author'] = $data['author'];
        }

        return $this->list_books_use_case->handle(relationships: ['author', 'category'], filters: $filters, per_page: $per_page);
    }

    /**
     * Create a BookApplication
     *
     * @param array $data
     * @return BookApplication
     */
    public function bookApply(array $data): BookApplication
    {
        /** @var User $current_user */
        $current_user = Auth::user();

        $data['user_id'] = $current_user->id;

        $book_application = $this->create_book_application_use_case->handle(data: $data);

        $current_user->notify(new BookApplicationCreatedNotification(book_application: $book_application));

        return $book_application;
    }
}
