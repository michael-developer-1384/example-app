<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get all companies where the authenticated user is an Admin
        $adminCompanies = $user->companiesWithRole()->wherePivot('role_id', Role::where('name', 'Administrator')->first()->id)->pluck('companies.id');

        // Get all participants that belong to these companies
        $participants = User::whereHas('companiesWithRole', function ($query) use ($adminCompanies) {
            $query->whereIn('companies.id', $adminCompanies);
        })->distinct()->get();
        
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

        // Assign roles to companies
        if ($request->has('companies')) {
            foreach ($request->input('companies') as $companyId) {
                if (isset($request->input('roles')[$companyId])) {
                    $roleIds = $request->input('roles')[$companyId];
                    $participant->rolesInCompanies()->attach($roleIds, ['company_id' => $companyId]);
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
