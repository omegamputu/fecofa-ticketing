@component('mail::message')
# Bonjour {{ $user->name }},

Vous avez été invité à utiliser la plateforme **FECOFA Ticketing** pour gérer vos demandes et incidents.

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Définir mon mot de passe
@endcomponent

Ce lien expirera dans **{{ $expires }} minutes**.

Si vous n’êtes pas à l’origine de cette invitation, ignorez cet email.

Merci,  
**FECOFA Ticketing**  
Direction des Systèmes d’Information

@slot('subcopy')
Si le bouton ne fonctionne pas, copiez-collez ce lien dans votre navigateur :  
{{ $url }}
@endslot
@endcomponent
