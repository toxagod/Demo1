<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->checkAdmin();
    }

    private function checkAdmin()
    {
        if (!session('is_admin')) {
            return redirect()->route('login')->send();
        }
    }

    public function dashboard(Request $request)
    {
        $query = Application::with(['user', 'course'])
            ->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(10);

        return view('admin.dashboard', compact('applications'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,completed'
        ]);

        $application->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Статус обновлен!');
    }
}
