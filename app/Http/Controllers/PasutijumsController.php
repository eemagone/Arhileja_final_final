<?php

namespace App\Http\Controllers;

use App\Models\Apavi;
use App\Models\FilialuKrajumi;
use App\Models\Klients;
use App\Models\Materiali;
use App\Models\Meistars;
use App\Models\Pasutijums;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasutijumsController extends Controller
{
    /**
     * Lietotāja informācijas panelis - atšķiras pēc lomas.
     */
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $pasutijumi = Pasutijums::with(['apavi.klients', 'meistars.filiale'])
                ->orderByDesc('Pasutijumi_ID')
                ->get();

            return view('dashboard-admin', compact('pasutijumi'));
        }

        if ($user->isMaster()) {
            $meistars = $user->meistars;

            // Pasūtījumi, kas piesaistīti šim meistaram
            $maniPasutijumi = Pasutijums::with(['apavi.klients'])
                ->where('Meistara_ID', $meistars->Meistari_ID)
                ->orderByDesc('Pasutijumi_ID')
                ->get();

            // Jauni pasūtījumi (nav piesaistīts meistars) no šīs filiāles apaviem
            $jauniePasutijumi = Pasutijums::with(['apavi.klients'])
                ->whereNull('Meistara_ID')
                ->where('Statuss', 'Jauns')
                ->orderByDesc('Pasutijumi_ID')
                ->get();

            return view('dashboard-meistars', compact('meistars', 'maniPasutijumi', 'jauniePasutijumi'));
        }

        // Klients
        $klients = $user->klients;

        $pasutijumi = $klients
            ? Pasutijums::with(['apavi', 'meistars.filiale', 'atsauksme'])
                ->whereHas('apavi', function ($q) use ($klients) {
                    $q->where('Klienta_ID', $klients->Klienti_ID);
                })
                ->orderByDesc('Pasutijumi_ID')
                ->get()
            : collect();

        return view('dashboard-klients', compact('klients', 'pasutijumi'));
    }

    /**
     * Jauna pasūtījuma forma (klients ievada info par apaviem un remontu).
     */
    public function create()
    {
        $user = Auth::user();

        if (!$user->isClient()) {
            abort(403, 'Tikai klienti var izveidot jaunus pasūtījumus.');
        }

        return view('orders.create');
    }

    /**
     * Saglabā jaunu Apavi ierakstu un saistīto Pasūtījumu.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->isClient()) {
            abort(403, 'Tikai klienti var izveidot jaunus pasūtījumus.');
        }

        $validated = $request->validate([
            'zimols' => 'nullable|string|max:100',
            'tips' => 'required|string|max:100',
            'apavu_materials' => 'nullable|string|max:100',
            'remonta_veids' => 'required|string|max:255',
            'termins' => 'nullable|date',
        ]);

        $klients = $user->klients;

        if (!$klients) {
            return back()->with('error', 'Klienta profils nav atrasts.');
        }

        $pasutijums = DB::transaction(function () use ($validated, $klients) {
            $apavi = Apavi::create([
                'Klienta_ID' => $klients->Klienti_ID,
                'Zimols' => $validated['zimols'] ?? null,
                'Tips' => $validated['tips'],
                'ApavuMaterials' => $validated['apavu_materials'] ?? null,
            ]);

            return Pasutijums::create([
                'Apavu_ID' => $apavi->Apavi_ID,
                'Meistara_ID' => null,
                'Pienemsanas_Datums' => now()->format('Y-m-d'),
                'Termins' => $validated['termins'] ?? null,
                'RemontaVeids' => $validated['remonta_veids'],
                'Statuss' => 'Jauns',
                'Cena' => 0.00,
                'Garantijas_Termins' => null,
            ]);
        });

        return redirect()->route('orders.show', $pasutijums->Pasutijumi_ID)
            ->with('success', 'Pasūtījums veiksmīgi izveidots!');
    }

    /**
     * Pasūtījuma detalizēta informācija.
     */
    public function show(Pasutijums $pasutijums)
    {
        $user = Auth::user();
        $pasutijums->load(['apavi.klients', 'meistars.filiale', 'materiali', 'atsauksme']);

        // Pieejas kontrole
        if ($user->isClient()) {
            $klients = $user->klients;
            if (!$klients || $pasutijums->apavi->Klienta_ID !== $klients->Klienti_ID) {
                abort(403, 'Šis pasūtījums nepieder jums.');
            }
        } elseif ($user->isMaster()) {
            $meistars = $user->meistars;
            $piederFiliale = $meistars && $pasutijums->Meistara_ID === $meistars->Meistari_ID;
            $brivs = $pasutijums->Meistara_ID === null;

            if (!$piederFiliale && !$brivs) {
                abort(403, 'Šis pasūtījums nav pieejams jums.');
            }
        }
        // administrators - pilna piekļuve

        $materiali = Materiali::all();

        return view('orders.show', compact('pasutijums', 'materiali'));
    }

    /**
     * Aprēķina pasūtījuma kopējo cenu pēc izmantotajiem materiāliem
     * un norakstu noliktavu (Filiāļu krājumi).
     */
    public function calculatePrice(Request $request, Pasutijums $pasutijums)
    {
        $user = Auth::user();

        if (!$user->isMaster() && !$user->isAdmin()) {
            abort(403, 'Tikai meistars var pievienot materiālus pasūtījumam.');
        }

        if ($pasutijums->atsauksme) {
            abort(403, 'Pasūtījums ir slēgts — klients ir atstājis atsauksmi.');
        }

        $validated = $request->validate([
            'materiali' => 'required|array|min:1',
            'materiali.*.materiali_id' => 'required|exists:Materiali,Materiali_ID',
            'materiali.*.daudzums' => 'required|integer|min:1',
            'darba_cena' => 'nullable|numeric|min:0',
        ]);

        $meistars = $user->meistars;
        $filialesId = $meistars?->filiale?->Filiales_ID;

        DB::transaction(function () use ($validated, $pasutijums, $filialesId) {

            // 1. Pievieno/atjaunina jaunos materiālus un noraksta no krājumiem
            foreach ($validated['materiali'] as $item) {
                $materials = Materiali::findOrFail($item['materiali_id']);
                $daudzums = (int) $item['daudzums'];

                // Pārbauda un noraksta no filiāles krājumiem
                if ($filialesId) {
                    $krajums = FilialuKrajumi::where('Filiales_ID', $filialesId)
                        ->where('Materiali_ID', $materials->Materiali_ID)
                        ->first();

                    if (!$krajums || $krajums->Apjoms < $daudzums) {
                        throw new \Exception('Nepietiek materiāla "' . $materials->Nosaukums . '" krājumos.');
                    }

                    $krajums->decrement('Apjoms', $daudzums);
                }

                // Ja šis materiāls jau ir pasūtījumā — pieskaita klāt daudzumu
                $existing = $pasutijums->materiali()->wherePivot('Materiali_ID', $materials->Materiali_ID)->first();
                if ($existing) {
                    $pasutijums->materiali()->updateExistingPivot(
                        $materials->Materiali_ID,
                        ['Daudzums' => $existing->pivot->Daudzums + $daudzums]
                    );
                } else {
                    $pasutijums->materiali()->attach($materials->Materiali_ID, ['Daudzums' => $daudzums]);
                }
            }

            // 2. Pārrēķina cenu no VISIEM pasūtījuma materiāliem (arī iepriekšējiem)
            $pasutijums->load('materiali');
            $materialuSumma = $pasutijums->materiali->sum(function ($m) {
                return $m->Cena * $m->pivot->Daudzums;
            });

            // 3. Darba cena — ņem no formas ja norādīta, citādi saglabā iepriekšējo
            $darbaCena = isset($validated['darba_cena']) && $validated['darba_cena'] !== null
                ? (float) $validated['darba_cena']
                : 0;

            $pasutijums->update([
                'Cena' => $materialuSumma + $darbaCena,
            ]);
        });

        return redirect()->route('orders.show', $pasutijums->Pasutijumi_ID)
            ->with('success', 'Cena pārrēķināta un materiāli norakstīti no krājumiem.');
    }

    /**
     * Maina pasūtījuma statusu (meistars pieņem darbu, maina progresu, pabeidz).
     */
    public function updateStatus(Request $request, Pasutijums $pasutijums)
    {
        $user = Auth::user();

        if (!$user->isMaster() && !$user->isAdmin()) {
            abort(403, 'Tikai meistars var mainīt pasūtījuma statusu.');
        }

        if ($pasutijums->atsauksme) {
            abort(403, 'Pasūtījums ir slēgts — klients ir atstājis atsauksmi.');
        }

        $validated = $request->validate([
            'statuss' => 'required|in:Jauns,Procesā,Gatavs,Atcelts',
        ]);

        // Ja meistars pieņem jaunu pasūtījumu, piesaista viņu pasūtījumam
        if ($pasutijums->Meistara_ID === null && $user->isMaster()) {
            $meistars = $user->meistars;
            $pasutijums->Meistara_ID = $meistars->Meistari_ID;
        }

        $pasutijums->Statuss = $validated['statuss'];

        // Iestata garantijas termiņu, kad darbs pabeigts
        if ($validated['statuss'] === 'Gatavs' && !$pasutijums->Garantijas_Termins) {
            $pasutijums->Garantijas_Termins = now()->addMonths(6)->format('Y-m-d');
        }

        $pasutijums->save();

        return redirect()->route('orders.show', $pasutijums->Pasutijumi_ID)
            ->with('success', 'Pasūtījuma statuss atjaunināts uz "' . $validated['statuss'] . '".');
    }
}