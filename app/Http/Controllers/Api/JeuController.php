<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JeuRequest;
use App\Http\Resources\JeuRessource;
use App\Models\Achat;
use App\Models\Jeu;
use Exception;
use Illuminate\Http\Request;

class JeuController extends Controller
{
    public function index(Request $request = null) {
        $jeux = Jeu::all();
        if(!empty($request)) {
            foreach ($jeux as $jeu) {
                if ($request->age_min < $jeu->age_min) {
                    $jeux->forget($jeu);
                }
            }
        }
        return JeuRessource::collection($jeux);
    }

    public function storeJeu(JeuRequest $request) {
        // Ici les données ont été validées dans la classe JeuRequest
        try {
            $jeu = new Jeu();
            $jeu->nom = $request->nom;
            $jeu->description = $request->description;
            $jeu->langue = $request->langue;
            $jeu->url_media = "images/no_image.png";
            $jeu->age_min = $request->age_min;
            $jeu->nombre_joueurs_min = $request->nombre_joueurs_min;
            $jeu->nombre_joueurs_max = $request->nombre_joueurs_max;
            $jeu->duree_partie = $request->duree_partie;
            $jeu->valide = true;
            $jeu->categorie_id = $request->categorie_id;
            $jeu->theme_id = $request->theme_id;
            $jeu->editeur_id = $request->editeur_id;
            $jeu->save();
            return response()->json(['status' => "success", 'message' => "Game created successfully!", 'jeu' => $jeu]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => "Error game create", 'error' => $e],422);
        }
    }

    public function updateJeu(JeuRequest $request, $id) {
        try {
            $jeu = Jeu::findOrFail($id);
            $jeu->update($request->all());
            return response()->json(['status' => 'success', 'message' => "Game updated successfully!", 'jeu' => $jeu], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => "Error game update", 'error' => $e], 422);
        }
    }

    public function updateUrl(Request $request, $id) {
        try {
            $this->validate($request, [
                'url_media' => 'required',
            ]);
            $jeu = Jeu::findOrFail($id);
            $jeu->url_media = $request->input('url_media');
            $jeu->save();
            return response()->json(['status' => 'success', 'message' => "Game url media updated successfully!", 'url_media' => $jeu->url_media], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => "Error Game url media", 'error' => $e,], 422);
        }
    }

    public function storeAchat(JeuRequest $request) {
        // Ici les données ont été validées dans la classe JeuRequest
        try {
            $achat = new Achat();
            $achat->date_achat = $request->date_achat;
            $achat->lieu_achat = $request->lieu_achat;
            $achat->prix = $request->prix;
            $achat->adherent_id = $request->adherent_id;
            $achat->jeu_id = $request->jeu_id;
            $achat->save();
            return response()->json(['status' => "success", 'message' => "Game created successfully!", 'achat' => $achat]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => "Error game create", 'error' => $e],422);
        }
    }

}
