<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        // Überprüfen, ob der Benutzer mindestens eine Firma hat
        if (auth()->user()->companiesWithRole->count() == 0) {
            return redirect()->route('companies.index')
                ->with('warning', 'You need to have at least one company to add a participant.');
        }

        return view('participants.create', ['selectedCompany' => null]);
    }

    public function createFromCompany(Company $company)
    {
         // Überprüfen, ob der Benutzer mindestens eine Firma hat
         if (auth()->user()->companiesWithRole->count() == 0) {
            return redirect()->route('companies.index')
                ->with('warning', 'You need to have at least one company to add a participant.');
        }

        return view('participants.create', ['selectedCompany' => $company->id]);
    }

    public function store(Request $request)
    {
        // Validierung
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        // Generiere ein zufälliges Passwort
        $password = Str::random(10);
        $password_crypt = bcrypt($password);

        // User erstellen
        $participant = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password_crypt,
            'is_full_profile' => false,  // Set to false by default
            'must_change_password' => $request->has('must_change_password')  // Check if checkbox is selected
        ]);

        // Assign roles to companies
        if ($request->has('companies')) {
            foreach ($request->input('companies') as $companyId) {
                if (isset($request->input('roles')[$companyId])) {
                    $roleIds = $request->input('roles')[$companyId];
                    $participant->rolesInCompany()->attach($roleIds, ['company_id' => $companyId]);
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
