<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\Language;
use App\Models\ProjectLanguage;

class PlanningOverallInformationController extends Controller
{
    /**
     * Display the initial page of the Overall Information about the Planning
     */
    public function index(string $id_project)
    {
        $languages = Language::all();
        $projectLanguages = ProjectLanguage::where('id_project', $id_project)->get();
        $domains = Domain::where('id_project', $id_project)->get();
        return view('planning.index', compact('domains', 'id_project', 'languages', 'projectLanguages'));
    }

    // DOMAIN AREA
    /**
     * Store a newly created Domain
     */
    public function domainUpdate(Request $request)
    {
        $this->validate($request, [
            'description' =>'required|string',
        ]);

        Domain::create([
            'id_project' => $request->id_project,
            'description' => $request->description,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/".$id_project);
    }

    /*
    * Update an existing Domain of the project
    */
    public function domainEdit(Request $request, string $id)
    {
        $domain = Domain::findOrFail($id);
        $domain->update($request->all());
        $id_project = $domain->id_project;

        return redirect("/planning/".$id_project);
    }

    /*
    * Remove the specified Domain from the project
    */
    public function domainDestroy(string $id)
    {
         $domain = Domain::findOrFail($id);
         $id_project = $domain->id_project;
         $domain->delete();

         return redirect("/planning/".$id_project);
    }
    // DOMAIN AREA

    // LANGUAGE AREA
    /**
     * Add a language stored in the database to the project
     */
    public function languageAdd(Request $request)
    {
        $this->validate($request, [
            'id_language' =>'required|string',
        ]);

        ProjectLanguage::create([
            'id_project' => $request->id_project,
            'id_language' => $request->id_language,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/".$id_project);
    }

    /*
    * Remove the specified Domain from the project
    */
    public function languageDestroy(string $id)
    {
         $domain = Domain::findOrFail($id);
         $id_project = $domain->id_project;
         $domain->delete();

         return redirect("/planning/".$id_project);
    }
    // LANGUAGE AREA
}