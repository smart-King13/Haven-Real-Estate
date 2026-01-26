<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display notifications management page
     */
    public function index()
    {
        $notifications = Notification::with('user')
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => Notification::count(),
            'unread' => Notification::unread()->count(),
            'today' => Notification::whereDate('created_at', today())->count(),
        ];

        return view('admin.notifications.index', compact('notifications', 'stats'));
    }

    /**
     * Show create notification form
     */
    public function create()
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.notifications.create', compact('users'));
    }

    /**
     * Store new notification
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
            'icon' => 'nullable|string|max:50',
            'link' => 'nullable|url|max:255',
            'send_to' => 'required|in:all,specific',
            'user_ids' => 'required_if:send_to,specific|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        if ($request->send_to === 'all') {
            // Send to all users
            $users = User::where('role', 'user')->get();
            
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'message' => $request->message,
                    'type' => $request->type,
                    'icon' => $request->icon,
                    'link' => $request->link,
                    'send_to_all' => true,
                ]);
            }

            $message = 'Notification sent to all users successfully';
        } else {
            // Send to specific users
            foreach ($request->user_ids as $userId) {
                Notification::create([
                    'user_id' => $userId,
                    'title' => $request->title,
                    'message' => $request->message,
                    'type' => $request->type,
                    'icon' => $request->icon,
                    'link' => $request->link,
                    'send_to_all' => false,
                ]);
            }

            $count = count($request->user_ids);
            $message = "Notification sent to {$count} user(s) successfully";
        }

        return redirect()->route('admin.notifications.index')->with('success', $message);
    }

    /**
     * Delete notification
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted successfully');
    }

    /**
     * Delete all notifications
     */
    public function destroyAll()
    {
        Notification::truncate();
        return redirect()->route('admin.notifications.index')->with('success', 'All notifications deleted successfully');
    }
}
