<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class PushSubscriptionController extends Controller
{
    /**
     * Update user's push subscription.
     */
    public function update(Request $request): JsonResponse
    {
        $this->validate($request, [
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);

        $endpoint = $request->endpoint;
        $token = $request->keys['p256dh'];
        $key = $request->keys['auth'];

        $request->user()->updatePushSubscription($endpoint, $key, $token);
        $request->user()->update(['reminder_enabled' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete the user's push subscription.
     */
    public function destroy(Request $request): JsonResponse
    {
        $this->validate($request, ['endpoint' => 'required']);

        $request->user()->deletePushSubscription($request->endpoint);
        $request->user()->update(['reminder_enabled' => false]);

        return response()->json(['success' => true]);
    }
}
