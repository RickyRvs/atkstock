<?php

namespace App\Http\Middleware;

use App\Models\Instansi;
use Closure;
use Illuminate\Http\Request;

class SetInstansiAktif
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user) {
            $aksesibelIds = $user->instansiAksesibel()->pluck('instansi.id');
            $instansiId   = session('instansi_aktif_id');

            if (!$instansiId || !$aksesibelIds->contains($instansiId)) {
                $instansiId = $user->instansiHome()?->id ?? $aksesibelIds->first();
                session(['instansi_aktif_id' => $instansiId]);
            }

            if ($instansiId) {
                app()->instance('instansi_aktif', Instansi::find($instansiId));
            }
        }

        return $next($request);
    }
}