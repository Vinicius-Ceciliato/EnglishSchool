<?php

namespace App\Http\Controllers;

use App\Mail\NewReviewSubmitted;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = Review::create([
            'author_name' => $request->user()->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'approved' => false, // admin precisa aprovar antes de aparecer no site
        ]);

        Mail::to(config('mail.admin_address'))->send(new NewReviewSubmitted($review));

        return back()->with('status', 'Avaliação enviada! Obrigado pelo seu feedback.');
    }
}