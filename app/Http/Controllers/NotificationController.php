<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }

    public function index()
    {
        return response()->json([
            'read' => NotificationResource::collection(auth()->user()->readNotifications),
            'unread' => NotificationResource::collection(auth()->user()->unreadNotifications),
        ]);
    }

    public function markAsRead(Request $request)
    {
        auth()->user()->notifications()->where('id', $request->id)->first()->markAsRead();
        return response('Read', Response::HTTP_NO_CONTENT);
    }
}
