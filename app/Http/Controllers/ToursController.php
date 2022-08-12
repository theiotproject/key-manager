<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToursController extends Controller
{
    public function update()
    {
        request()->validate(['tour' => ['required', 'string']]);

        $user = request()->user();
        $user->update([
            'tours' => array_merge(
                $user->tours ?? [],
                [request('tour') => true]
            )
        ]);
        $user->save();
        return $user;
        return response()->noContent();
    }
}
