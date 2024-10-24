<html>
    <div>
        <h1> Olá, {{ $name }}</h1>
    </div>

    <div>
        <a href="{{ config('app.url') }}/setNewPassword?token={{$recovery_password}}">
            Clique aqui para recuperar sua senha
        </a>
    </div>
</html>
