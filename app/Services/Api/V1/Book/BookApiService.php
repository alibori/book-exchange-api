<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Book;

use App\Enums\BookUserStatusEnum;
use App\Exceptions\ApiException;
use App\Models\BookApplication;
use App\Models\BookUser;
use App\Models\User;
use App\Notifications\Book\BookApplicationCreatedNotification;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Src\Book\Application\UseCases\CreateBookApplicationUseCase;
use Src\Book\Application\UseCases\CreateBookUserUseCase;
use Src\Book\Application\UseCases\GetBookUserUseCase;
use Src\Book\Application\UseCases\ListBooksUseCase;
use Src\Book\Application\UseCases\UpdateBookUserUseCase;
use Symfony\Component\HttpFoundation\Response;

final class BookApiService
{
    public function __construct(
        private readonly ListBooksUseCase $list_books_use_case,
        private readonly CreateBookApplicationUseCase $create_book_application_use_case,
        private readonly GetBookUserUseCase $get_book_user_use_case,
        private readonly CreateBookUserUseCase $create_book_user_use_case,
        private readonly UpdateBookUserUseCase $update_book_user_use_case
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

        if (isset($data['library'])) {
            $filters['library'] = $data['library'];
        }

        return $this->list_books_use_case->handle(relationships: ['author', 'category', 'users'], filters: $filters, per_page: $per_page);
    }

    /**
     * Add a Book in the User's Library
     *
     * @param array $data
     * @return BookUser
     * @throws ApiException
     */
    public function addToLibrary(array $data): BookUser
    {
        $current_user_id = Auth::id();

        $data['user_id'] = $current_user_id;

        $book_user = $this->get_book_user_use_case->handle(user_id: $current_user_id, book_id: (int)$data['book_id']);

        if ($book_user) {
            throw new ApiException(message: trans(key: 'errors.book.already_in_library'), code: Response::HTTP_BAD_REQUEST);
        }

        return $this->create_book_user_use_case->handle(data: $data);
    }

    /**
     * Remove a Book from the User's Library
     *
     * @param string $book_id
     * @return bool
     * @throws ApiException
     */
    public function removeFromLibrary(string $book_id): bool
    {
        $current_user_id = Auth::id();

        if (!is_numeric($book_id)) {
            throw new ApiException(trans(key: 'errors.invalid_query_parameters'), Response::HTTP_BAD_REQUEST);
        }

        $book_user = $this->get_book_user_use_case->handle(user_id: $current_user_id, book_id: (int)$book_id);

        if (!$book_user) {
            throw new ApiException(trans(key: 'errors.book.not_in_library'), Response::HTTP_NOT_FOUND);
        } elseif ($book_user->status === (BookUserStatusEnum::Borrowed)->value) {
            throw new ApiException(trans(key: 'errors.book.is_borrowed'), Response::HTTP_FORBIDDEN);
        }

        return $book_user->delete();
    }

    /**
     * Update Book's q from the User's Library
     *
     * @param array $data
     * @param string $book_id
     * @return bool
     * @throws ApiException
     */
    public function updateInLibrary(array $data, string $book_id): bool
    {
        $current_user_id = Auth::id();
        $data['user_id'] = $current_user_id;
        $data['book_id'] = $book_id;

        if (!is_numeric($book_id)) {
            throw new ApiException(trans(key: 'errors.invalid_query_parameters'), Response::HTTP_BAD_REQUEST);
        }

        $book_user = $this->get_book_user_use_case->handle(user_id: $current_user_id, book_id: (int)$book_id);

        if (!$book_user) {
            throw new ApiException(trans(key: 'errors.book.not_in_library'), Response::HTTP_NOT_FOUND);
        }

        return $this->update_book_user_use_case->handle(data: $data, book_user: $book_user);
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
