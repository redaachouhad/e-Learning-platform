<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\RequestFollow;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    /**
     * Toggle Follow / Unfollow a user.
     */

    public function toggleFollow(RequestFollow $request)
    {
        $validated = $request->validated();

        $follow = Follow::where('followed_id', $validated['followed_id'])
            ->where('follower_id', Auth::user()->id)
            ->first();
        $message = '';
        $followed = false;
        if ($follow) {
            // If the follow relationship exists, delete it to unfollow
            $follow->delete();
            $message = 'Unfollowed successfully';
            $followed = false;
        } else {
            // If the follow relationship does not exist, create it to follow
            Follow::create([
                'followed_id' => $validated['followed_id'],
                'follower_id' => Auth::user()->id,
            ]);

            $message = 'Followed successfully';
            $followed = true;
        }
        // Fetch the creator with their followers and followings count
        $creator = User::withCount('followers')
            ->withCount('followings')
            ->findOrFail($validated['followed_id']);
        return response()->json([
            'message' => $message,
            'followed' => $followed,
            'followings_count' => $creator->followings_count,
            'followers_count' => $creator->followers_count
        ], 200);
    }
}
