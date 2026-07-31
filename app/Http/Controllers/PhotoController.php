<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        $query = Photo::with(['user:id,name', 'category:id,name'])->withCount('likes');

        // Filtrage optionnel par catégorie
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $photos = $query->latest()->get()->map(function ($photo) use ($request) {
            return [
                'id' => $photo->id,
                'title' => $photo->title,
                'url' => asset('storage/' . $photo->image_path),
                'category' => $photo->category->name,
                'publisher' => $photo->user->name,
                'likes_count' => $photo->likes_count,
                // Vérifie si l'utilisateur connecté a liké cette photo
                'is_liked' => $request->user('sanctum')
                    ? $photo->likes()->where('user_id', $request->user('sanctum')->id)->exists()
                    : false
            ];
        });

        return response()->json($photos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
        ]);

        // Upload direct vers le bucket S3 en mode public
        $path = $request->file('image')->store('photos', 's3');

        // Note : storePublicly() assure que le fichier est lisible par tout le monde sur Internet
        // $path = $request->file('image')->storePublicly('pixabay-photos', 's3');

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
                'url' => Storage::url($photo->image_path), // URL CDN / S3 Générée
            ]
        ], 201);
    }

    public function toggleLike(Request $request, Photo $photo)
    {
        $user = $request->user();

        // Ajoute ou supprime le like
        $likeStatus = $photo->likes()->toggle($user->id);
        $liked = count($likeStatus['attached']) > 0;

        return response()->json([
            'message' => $liked ? 'Photo likée' : 'Like retiré',
            'liked' => $liked,
            'likes_count' => $photo->likes()->count()
        ]);
    }

    public function destroy(Request $request, Photo $photo)
    {
        if ($photo->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Action non autorisée'], 403);
        }

        // Suppression du fichier directement depuis le bucket S3
        //Storage::disk('s3')->delete($photo->image_path);
        $photo->delete();

        return response()->json(['message' => 'Photo supprimée avec succès']);
    }
}
