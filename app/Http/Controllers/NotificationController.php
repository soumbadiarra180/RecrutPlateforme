<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('candidature.offre')
            ->where('id_candidat', auth()->user()->id_candidat)
            ->latest()
            ->paginate(15);

        Notification::where('id_candidat', auth()->user()->id_candidat)
            ->where('lu', false)
            ->update(['lu' => true]);

        return view('notifications.index', compact('notifications'));
    }
}