<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        // Get the ID of the 'Administrator' role
        $adminRoleId = Role::where('name', 'Administrator')->first()->id;

        // Fetch companies where the authenticated user has the 'Administrator' role
        $companies = Auth::user()->companiesWithRole->filter(function ($company) use ($adminRoleId) {
            return $company->pivot->role_id == $adminRoleId;
        });

        return view('companies.index', ['companies' => $companies]);
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255', // Validiert, dass es sich um eine gültige URL handelt
            'phone' => 'nullable|string|max:20', // Annahme, dass die Telefonnummer nicht länger als 20 Zeichen ist
            // ... weitere Validierungsregeln
        ]);
        

        // Erstelle eine neue Company mit den validierten Daten
        $company = Company::create($data);

        // Füge den eingeloggten Benutzer zur Liste der Benutzer der Company hinzu
        $company->usersWithRole()->attach(auth()->user()->id);

        return redirect()->route('companies.index')->with('success', 'Company created.');
    }

    public function show(Company $company)
    {
        // Überprüfen, ob der Benutzer Zugriff auf die Company hat
        if (!Auth::user()->companiesWithRole->contains($company)) {
            return redirect()->route('companies.index')->with('error', 'Access denied to view the company.');
        }

        $company = Company::with('usersWithRole')->find($company->id);
        $uniqueUsers = $company->usersWithRole->unique('id');

        return view('companies.show', ['company' => $company, 'uniqueUsers' => $uniqueUsers]);
    }

    public function edit(Company $company)
    {
        return view('companies.edit', ['company' => $company]);
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'address' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        
        $company->update($request->all());
        return redirect()->route('companies.index');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index');
    }
}
