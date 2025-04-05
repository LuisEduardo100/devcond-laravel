<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Wall;
use App\Models\WallLike;

class WallController extends Controller
{
    public function getAll()
    {
        $array = ['error' => '', 'list' => []];
        $user = Auth::user();
        $wall = Wall::all();

        foreach ($wall as $wallKey => $wallValue) {
            $walls[$wallKey]['id'] = $wallValue['id'];
            $walls[$wallKey]['title'] = $wallValue['title'];
            $walls[$wallKey]['body'] = $wallValue['body'];
            $walls[$wallKey]['likes'] = 0;
            $walls[$wallKey]['liked'] = false;

            $likes = WallLike::where('id_wall', $wallValue['id'])->count();
            $walls[$wallKey]['likes'] = $likes;

            $liked = WallLike::where('id_wall', $wallValue['id'])
                ->where('id_user', $user['id'])
                ->count();

            if ($liked > 0) {
                $walls[$wallKey]['liked'] = true;
            }
        }

        $array['list'] = $walls;
        return $array;
    }

    public function like($id)
    {
        $array = ['error' => ''];
        $user = Auth::user();

        $liked = WallLike::where('id_wall', $id)
            ->where('id_user', $user['id'])
            ->count();

        if ($liked > 0) {
            WallLike::where('id_wall', $id)
                ->where('id_user', $user['id'])
                ->delete();
            $array['liked'] = false;
        } else {
            $newLike = new WallLike();
            $newLike->id_wall = $id;
            $newLike->id_user = $user['id'];
            $newLike->save();
            $array['liked'] = true;
        }

        return $array;
    }
}
