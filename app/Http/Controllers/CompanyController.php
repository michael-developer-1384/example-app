<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', ['companies' => $companies]);
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        // Validiere die Eingabedaten
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Erstelle eine neue Company mit den validierten Daten
        $company = Company::create($data);

        // Füge den eingeloggten Benutzer zur Liste der Benutzer der Company hinzu
        $company->users()->attach(auth()->user()->id);

        return redirect()->route('companies.index');
    }

    public function show(Company $company)
    {
        $company = Company::with('users')->find($company->id);
        dd($company);
        return view('companies.show', ['company' => $company]);
    }

    public function edit(Company $company)
    {
        return view('companies.edit', ['company' => $company]);
    }

    public function update(Request $request, Company $company)
    {
        $company->update($request->all());
        return redirect()->route('companies.index');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index');
    }
}
