<?php

namespace App\Http\Controllers;
use App\Models\Reclamation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ReclamationController extends Controller
{
    public function index()
{
    if (Auth::check()) {
        $email = Auth::user()->email;

        // Vérifie si l'email est vide
        if (empty($email)) {
            return to_route('login')->with('error', 'Veuillez vous reconnecter.');
        }
    $reclamations = Reclamation::where('etat_reclamation', 'En cours')
        ->with('etudiant')
        ->get();

    return view('reclamations', compact('reclamations'));
    }else{
        return to_route('login');
    }
}

public function update($id)
{
    if (Auth::check()) {
        $email = Auth::user()->email;

        // Vérifie si l'email est vide
        if (empty($email)) {
            return to_route('login')->with('error', 'Veuillez vous reconnecter.');
        }
    try {
        // Trouver la réclamation par ID
        $reclamation = Reclamation::findOrFail($id);

        // Exemple de mise à jour
        $reclamation->etat_reclamation = 'Traitée';
        // Ajustez en fonction de votre logique
        $reclamation->save();

        // Réponse JSON réussie
        return response()->json(['success' => true, 'message' => 'Réclamation mise à jour avec succès.']);
    } catch (\Exception $e) {
        // Log de l'erreur
        \Log::error($e->getMessage());

        // Réponse JSON avec erreur
        return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour.'], 500);
    }
}else{
    return to_route('login');
}
}

}