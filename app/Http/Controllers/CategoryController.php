<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('visible', true)
            ->select('id', 'name', 'slug')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($categories);
    }

    /**
     * Créer une nouvelle catégorie (Authentification requise)
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'visible' => 'nullable|boolean',
        ]);

        $category = Category::create([
            'name' => $fields['name'],
            'slug' => Str::slug($fields['name']),
            'visible' => $fields['visible'] ?? true,
            'user_id' => $request->user()->id, // Créateur de la catégorie
        ]);

        return response()->json([
            'message' => 'Catégorie créée avec succès',
            'category' => $category
        ], 201);
    }

    /**
     * Obtenir une catégorie spécifique avec ses photos
     */
    public function show(Category $category)
    {
        if (!$category->visible) {
            return response()->json(['message' => 'Catégorie non trouvée ou masquée'], 404);
        }

        return response()->json([
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'photos_count' => $category->photos()->count(),
        ]);
    }

    /**
     * Mettre à jour une catégorie (ex: basculer la visibilité ou changer le nom)
     */
    public function update(Request $request, Category $category)
    {
        // Seul le créateur de la catégorie peut la modifier
        if ($category->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Action non autorisée'], 403);
        }

        $fields = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $category->id,
            'visible' => 'sometimes|boolean',
        ]);

        if (isset($fields['name'])) {
            $category->name = $fields['name'];
            $category->slug = Str::slug($fields['name']);
        }

        if (isset($fields['visible'])) {
            $category->visible = $fields['visible'];
        }

        $category->save();

        return response()->json([
            'message' => 'Catégorie mise à jour',
            'category' => $category
        ]);
    }

    /**
     * Supprimer une catégorie
     */
    public function destroy(Request $request, Category $category)
    {
        if ($category->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Action non autorisée'], 403);
        }

        $category->delete();

        return response()->json(['message' => 'Catégorie supprimée avec succès']);
    }
}
