<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Loan;

use App\Http\Concerns\HasLogs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class LoanApiController extends Controller
{
    use HasLogs;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
