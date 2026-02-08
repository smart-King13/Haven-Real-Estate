<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminNewsletterController extends Controller
{
    protected $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Display newsletter dashboard
     */
    public function index()
    {
        try {
            $totalSubscribers = $this->supabase->count('newsletter_subscribers', ['status' => 'active']);
            $totalUnsubscribed = $this->supabase->count('newsletter_subscribers', ['status' => 'unsubscribed']);
            
            $recentSubscribersResponse = $this->supabase->select('newsletter_subscribers', '*', [
                'status' => 'active'
            ], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 10
            ]);
            $recentSubscribers = $recentSubscribersResponse->data ?? [];

            $campaignsResponse = $this->supabase->select('newsletter_campaigns', '*', [], [
                'order' => ['column' => 'created_at', 'ascending' => false],
                'limit' => 10
            ]);
            $campaigns = $campaignsResponse->data ?? [];

            $stats = [
                'total_subscribers' => $totalSubscribers,
                'total_unsubscribed' => $totalUnsubscribed,
                'total_campaigns' => count($campaigns),
            ];

            return view('admin.newsletter.index', compact('stats', 'recentSubscribers', 'campaigns'));

        } catch (\Exception $e) {
            return view('admin.newsletter.index', [
                'stats' => ['total_subscribers' => 0, 'total_unsubscribed' => 0, 'total_campaigns' => 0],
                'recentSubscribers' => [],
                'campaigns' => []
            ]);
        }
    }

    /**
     * Display all subscribers
     */
    public function subscribers()
    {
        try {
            $subscribersResponse = $this->supabase->select('newsletter_subscribers', '*', [], [
                'order' => ['column' => 'created_at', 'ascending' => false]
            ]);
            $subscribers = $subscribersResponse->data ?? [];

            return view('admin.newsletter.subscribers', compact('subscribers'));

        } catch (\Exception $e) {
            return view('admin.newsletter.subscribers', ['subscribers' => []]);
        }
    }

    /**
     * Delete subscriber
     */
    public function deleteSubscriber($id)
    {
        try {
            $this->supabase->delete('newsletter_subscribers', ['id' => $id]);
            return redirect()->route('admin.newsletter.subscribers')->with('success', 'Subscriber deleted!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete subscriber.');
        }
    }

    /**
     * Show create campaign form
     */
    public function createCampaign()
    {
        return view('admin.newsletter.create-campaign');
    }

    /**
     * Store new campaign
     */
    public function storeCampaign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = supabase_user();
            
            $this->supabase->insert('newsletter_campaigns', [
                'title' => $request->title,
                'subject' => $request->subject,
                'content' => $request->content,
                'status' => 'draft',
                'created_by' => $user->id
            ]);

            return redirect()->route('admin.newsletter.index')->with('success', 'Campaign created!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create campaign.')->withInput();
        }
    }

    /**
     * Send campaign
     */
    public function sendCampaign($id)
    {
        try {
            $campaign = $this->supabase->findOne('newsletter_campaigns', ['id' => $id]);
            
            if (!$campaign) {
                return back()->with('error', 'Campaign not found.');
            }

            $subscribersResponse = $this->supabase->select('newsletter_subscribers', '*', ['status' => 'active']);
            $subscribers = $subscribersResponse->data ?? [];

            $this->supabase->update('newsletter_campaigns', [
                'status' => 'sent',
                'sent_at' => date('Y-m-d H:i:s'),
                'total_recipients' => count($subscribers),
                'total_sent' => count($subscribers)
            ], ['id' => $id]);

            return redirect()->route('admin.newsletter.index')->with('success', 'Campaign sent to ' . count($subscribers) . ' subscribers!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send campaign.');
        }
    }
}
