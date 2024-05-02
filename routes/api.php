<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::post('bugs', function (Request $request) {

    $request->validate([
        'site_id' => 'required|exists:sites,id',
        'message' => 'required|string',
        'url' => 'required|string',
        'code' => 'required',
        'file' => 'required|string',
        'line' => 'required',
        'method' => 'required|string',
        'path' => 'required|string',
    ]);

    $bug = new \App\Models\Bug();
    $bug->site_id = $request->site_id;
    $bug->env = $request->env;
    $bug->url = Str::limit($request->url, 250);
    $bug->user = $request->user;
    $bug->ip = $request->ip;
    $bug->user_agent = Str::limit($request->user_agent, 250);
    $bug->method = $request->method;
    $bug->path = Str::limit($request->path, 250);
    $bug->code = $request->code;
    $bug->file = Str::limit($request->file, 250);
    $bug->line = $request->line;
    $bug->message = Str::limit($request->message, 250);
    $bug->logged_at = now();
    $bug->save();

    return response()->json($bug, 201);

})->middleware(['auth:sanctum', 'ability:bugs']);

Route::post('sites', function (Request $request) {

    $request->validate([
        'name' => 'required|string|min:3',
        'url' => 'required|url',
        'description' => 'string|max:255',
    ]);

    $site = new \App\Models\Site();
    $site->name = $request->name;
    $site->description = $request->description;
    $site->url = $request->url;
    $site->save();

    return response()->json($site, 201);

})->middleware(['auth:sanctum', 'ability:sites']);

Route::put('sites/{site_id}', function (Request $request, $site_id) {

    $request->validate([
        'name' => 'string|min:3',
        'description' => 'string|max:255',
        'url' => 'url',
    ]);

    $site = \App\Models\Site::find($site_id);
    if (! $site) {
        return response()->json(['message' => 'Site not found'], 404);
    }

    if ($request->name) {
        $site->name = $request->name;
    }

    if ($request->description) {
        $site->description = $request->description;
    }

    if ($request->url) {
        $site->url = $request->url;
    }

    $site->save();

    return response()->json($site, 200);

})->middleware(['auth:sanctum', 'ability:sites']);

Route::delete('sites/{site_id}', function (Request $request, $site_id) {

    $request->validate([
        'name' => 'required|string',
        'url' => 'required|url',
    ]);

    $site = \App\Models\Site::find($site_id);
    if (! $site) {
        return response()->json(['message' => 'Site not found'], 404);
    }

    $site->delete();

    return response()->json(null, 204);

})->middleware(['auth:sanctum', 'ability:sites']);
