<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Nice;
use Illuminate\Support\Facades\Auth;

class NiceController extends Controller
{
    public function nice(Post $post, Request $request)
    {
        $already_niced = Nice::where('post_id', $post->id)->where('user_id', Auth::user()->id)->first();

        if(!$already_niced) {
            $nice = New Nice();
            $nice->post_id = $post->id;
            $nice->ip = $request->ip();
 
            if(Auth::check()){
                $nice->user_id=Auth::user()->id;
            }
            $nice->save();
        
        } else {
            $user = $request->ip();
            $nice = Nice::where('post_id', $post->id)->where('ip', $user)->first();
            $nice->delete();
        }
        $nices_count = Nice::where('post_id', $post->id)->count();
        $param = [
            'nices_count' => $nices_count,
        ];
        return response()->json($param);
    }

}
