<?php
use App\Models\User;

test('autenticacao do usuário deve retornar status 200 e flg error false', function(){
    $usuario = User::factory()->create();

    $response = $this->postJson('/api/login', [
        'email' => $usuario->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200)->assertJson([
        'error' => false
    ]);
});

test('não é permitido cadastrar um usuário com e-mail já cadastrado', function(){

    $usuario = User::factory()->create();
    $emailUsuarioJaExistente = $usuario->email;

    $response = $this->postJson('/api/register', [
        'name' => 'Jeferson',
        'last_name' => 'Oliveira',
        'email' => $emailUsuarioJaExistente,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email'])
        ->assertJson([
            'errors' => [
                'email' => ['Email já existente na base de dados']
            ]
        ]);

    $this->assertEquals(1, User::where('email', $emailUsuarioJaExistente)->count());
});

test('confirmação de senha deve ser igual a senha cadastrada', function(){

    $response = $this->postJson('/api/register', [
        'name' => 'Jeferson',
        'last_name' => 'Oliveira',
        'email' => 'testing@example.com',
        'password' => 'password',
        'password_confirmation' => 'password_teste',
    ]);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['password_confirmation']);
});
