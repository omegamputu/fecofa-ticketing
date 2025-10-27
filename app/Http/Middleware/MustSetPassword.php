<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustSetPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check())
        {
            $user = auth()->user();

            // ✅ Exemption Super-Admin
            if (method_exists($user, 'hasRole') && $user->hasRole('Super-Admin')) {
                return $next($request);
            }

            // Bloque tout utilisateur sans mot de passe “posé”
            if (is_null($user->password_set_at)) {
                auth()->logout();

                return redirect()->route('login')
                    ->withErrors([
                        'email' => 'Veuillez définir votre mot de passe via le lien d’invitation avant d’accéder à l’administration.',
                    ]);
            }
        }
        
        return $next($request);
    }
}
