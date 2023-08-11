<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = User::all(); // Sie können hier eine spezifische Abfrage verwenden, um nur bestimmte User als "Participants" abzurufen
        return view('participants.index', compact('participants'));
    }

    public function create()
    {
        return view('participants.create');
    }

    public function store(Request $request)
    {
        // Validierung
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Fügen Sie weitere Validierungsregeln hinzu, die spezifisch für "Participants" sind
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['is_full_profile'] = false;

        // User erstellen
        $participant = User::create($data);

        // Zuweisung der Unternehmen und Rollen
        if ($request->has('companies')) {
            foreach ($request->input('companies') as $companyId) {
                if (isset($request->input('roles')[$companyId])) {
                    $roleIds = array_unique($request->input('roles')[$companyId]); // Entfernen von Duplikaten
                    foreach ($roleIds as $roleId) {
                        $participant->roles()->attach($roleId, ['company_id' => $companyId]);
                    }
                }
            }
        }
        
        

        return redirect()->route('participants.index')->with('success', 'Participant successfully created.');
    }

    public function show(User $participant)
    {
        return view('participants.show', compact('participant'));
    }

    public function edit(User $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    public function update(Request $request, User $participant)
    {
        // Validierung
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $participant->id,
            // Fügen Sie weitere Validierungsregeln hinzu, die spezifisch für "Participants" sind
        ]);

        // User aktualisieren
        $participant->update($data);

        return redirect()->route('participants.index')->with('success', 'Participant successfully updated.');
    }

    public function destroy(User $participant)
    {
        $participant->delete();
        return redirect()->route('participants.index')->with('success', 'Participant successfully deleted.');
    }
}
