<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Publier une nouvelle photo (Upload sur le bucket Cloudflare R2 'photos')
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5 Mo
        ]);

        // 1. Stockage direct dans le disque 'photos' sans en-tête de visibilité ACL
        $path = $request->file('image')->store('gallery', 'photos');

        // 2. Création en BDD
        $photo = Photo::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'image_path' => $path,
        ]);

        return response()->json([
            'message' => 'Photo publiée avec succès !',
            'photo' => [
                'id' => $photo->id,
                'title' => $photo->title,
                // Génère l'URL publique depuis le disque 'photos'
                'url' => Storage::disk('photos')->url($photo->image_path),
            ]
        ], 201);
    }

    /**
     * Obtenir la liste des photos (Public)
     */
    public function index(Request $request)
    {
        $query = Photo::with(['user:id,name', 'category:id,name'])->withCount('likes');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $photos = $query->latest()->get()->map(function ($photo) use ($request) {
            return [
                'id' => $photo->id,
                'title' => $photo->title,
                'url' => Storage::disk('photos')->url($photo->image_path),
                'category' => $photo->category->name,
                'publisher' => $photo->user->name,
                'likes_count' => $photo->likes_count,
                'is_liked' => $request->user('sanctum')
                    ? $photo->likes()->where('user_id', $request->user('sanctum')->id)->exists()
                    : false
            ];
        });

        return response()->json($photos);
    }

    /**
     * Supprimer une photo
     */
    public function destroy(Request $request, Photo $photo)
    {
        if ($photo->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Action non autorisée'], 403);
        }

        // Suppression sur le disque 'photos'
        Storage::disk('photos')->delete($photo->image_path);
        $photo->delete();

        return response()->json(['message' => 'Photo supprimée avec succès']);
    }

}
