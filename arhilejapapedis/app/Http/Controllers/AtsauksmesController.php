<?php

namespace App\Http\Controllers;

use App\Models\Pasutijums;
use App\Models\Atsauksme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtsauksmeController extends Controller
{
    public function store(Request $request, Pasutijums $pasutijums)
    {
        //Pasutijums aint done
        if ($pasutijums->Statuss !== 'Gatavs') {
            return redirect()->route('orders.show', $pasutijums->Pasutijuma_ID)
                ->with('error', 'Sorry vecais, nevar ielikt atsauksmi par nepabeigtu darbu! 🛠️');
        }

        //ir atsauksme?
        $alreadyHasReview = Atsauksme::where('Pasutijuma_ID', $pasutijums->Pasutijuma_ID)->exists();

        if ($alreadyHasReview) {
            return redirect()->route('orders.show', $pasutijums->Pasutijuma_ID)
                ->with('error', 'Tu jau esi uzrakstījis atsauksmi šim pasūtījumam!');
        }

        $validated = $request->validate([
            'vertejums' => 'required|integer|min:1|max:5',
            'komentars' => 'nullable|string|max:500',
        ]);

        Atsauksme::create([
            'Pasutijuma_ID' => $pasutijums->Pasutijuma_ID,
            'Vertejums' => $validated['vertejums'],
            'Komentars' => $validated['komentars'],
            'Datums' => now()->format('Y-m-d'),
        ]);

        return redirect()->route('orders.show', $pasutijums->Pasutijuma_ID)
            ->with('success', 'Paldies par atsauksmi! Garantija aktivizēta. 🎉');
    }
}