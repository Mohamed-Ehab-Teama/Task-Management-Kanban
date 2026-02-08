<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $boards = Board::whereIn('team_id', function ($query) use ($user) {
            $query->select('team_id')
                ->from('team_user')
                ->where('user_id', $user->id);
        })
            ->with(['columns.tasks' => function ($query) use ($user) {
                // $query->whereHas('assignees', function ($q) use ($user) {
                //     $q->wherePivot('user_id'. $user->id);
                // });
                $query->whereHas('assignees', function ($q) use ($user) {
                    $q->where('users.id', $user->id);;
                })->with('assignees');
            }])
            ->get();

        // dd($boards->toArray());

        return view('index', compact('boards'));
    }
}
