<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Klients;
use App\Models\Meistars;
use App\Models\Filiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private function requireAdmin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Tikai administrators var piekļūt šai sadaļai.');
        }
    }

    public function users()
    {
        $this->requireAdmin();

        $users = User::with(['klients', 'meistars.filiale'])
            ->orderBy('role')
            ->orderBy('name')
            ->get();

        return view('admin.users', compact('users'));
    }

    public function editUser(User $user)
    {
        $this->requireAdmin();

        $filiales = Filiale::orderBy('Nosaukums')->get();
        $klients  = $user->klients;
        $meistars = $user->meistars;

        return view('admin.user-edit', compact('user', 'filiales', 'klients', 'meistars'));
    }

    public function updateUser(Request $request, User $user)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'role'        => 'required|in:administrators,meistars,klients',
            'vards'       => 'nullable|string|max:100',
            'uzvards'     => 'nullable|string|max:100',
            'telnr'       => 'nullable|string|max:20',
            'filiales_id' => 'nullable|exists:Filiales,Filiales_ID',
        ]);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
        ]);

        // Update role-specific profile
        if ($validated['role'] === 'klients') {
            // Remove meistars profile if switching roles
            $user->meistars?->delete();

            $user->klients()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'Vards'  => $validated['vards'] ?? $user->name,
                    'Uzvards'=> $validated['uzvards'] ?? '',
                    'TelNr'  => $validated['telnr'] ?? null,
                ]
            );
        } elseif ($validated['role'] === 'meistars') {
            // Remove klients profile if switching roles
            $user->klients?->delete();

            if (!$validated['filiales_id']) {
                return back()->withErrors(['filiales_id' => 'Meistariem jānorāda filiāle.'])->withInput();
            }

            $user->meistars()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'Vards'       => $validated['vards'] ?? $user->name,
                    'Uzvards'     => $validated['uzvards'] ?? '',
                    'TelNr'       => $validated['telnr'] ?? null,
                    'Filiales_ID' => $validated['filiales_id'],
                ]
            );
        } elseif ($validated['role'] === 'administrators') {
            // Admins don't need klients/meistars profiles
            $user->klients?->delete();
            $user->meistars?->delete();
        }

        return redirect()->route('admin.users')
            ->with('success', 'Lietotājs "' . $user->name . '" veiksmīgi atjaunināts.');
    }

    public function deleteUser(User $user)
    {
        $this->requireAdmin();

        if ($user->id === Auth::id()) {
            return back()->withErrors(['delete' => 'Nevar dzēst pašu sevi.']);
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'Lietotājs "' . $name . '" dzēsts.');
    }
}
