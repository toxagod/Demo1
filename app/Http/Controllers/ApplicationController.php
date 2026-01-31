<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->checkAuth();
    }

    private function checkAuth()
    {
        if (!session('user_id')) {
            return redirect()->route('login')->send();
        }

        if (session('is_admin')) {
            return redirect()->route('admin.dashboard')->send();
        }
    }

    public function index()
    {
        $applications = Application::with('course')->where('user_id', session('user_id'))->orderBy('created_at', 'desc')->get();

        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('applications.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date_format:d.m.Y',
            'payment_method' => 'required|in:cash,phone_transfer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $startDate = \DateTime::createFromFormat('d.m.Y', $request->start_date);

        Application::create([
            'user_id' => session('user_id'),
            'course_id' => $request->course_id,
            'start_date' => $startDate->format('Y-m-d'),
            'payment_method' => $request->payment_method,
            'status' => 'new'
        ]);

        return redirect()->route('applications.index')
            ->with('success', 'Заявка успешно создана!');
    }

    public function storeReview(Request $request, Application $application)
    {
        if ($application->user_id != session('user_id') || $application->status !== 'completed') {
            return redirect()->route('applications.index')
                ->with('error', 'Вы не можете оставить отзыв для этой заявки');
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $existingReview = Review::where('application_id', $application->id)->first();
        if ($existingReview) {
            return redirect()->route('applications.index')
                ->with('error', 'Вы уже оставляли отзыв для этой заявки');
        }

        Review::create([
            'user_id' => session('user_id'),
            'course_id' => $application->course_id,
            'application_id' => $application->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('applications.index')
            ->with('success', 'Отзыв успешно добавлен!');
    }
}
