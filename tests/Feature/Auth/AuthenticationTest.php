<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);

describe('autenticação', function(){
    it('usuário deve se autentica informando e-mail e senha', function(){
        $usuario = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $usuario->email,
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false
            ]);
    });

    it('é obrigatório informar o e-mail para autenticação', function(){
        $response = $this->postJson('/api/login', [
            'password' => 'password',
        ]);

        $response->assertStatus(422);
    });

    it('é obrigado informar a senha para autenticação', function(){
        $usuario = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $usuario->email
        ]);

        $response->assertStatus(422);
    });
});

describe('cadastro de usuário', function(){
    it('não é possível cadastrar usuário sem preencher os campos obrigatórios como e-mail e senha', function(){
        $response = $this->postJson('/api/register', []);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'last_name', 'email', 'password', 'password_confirmation']);
    });


    it('não é permitido cadastrar um usuário com e-mail já cadastrado', function(){
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

    it('confirmação de senha deve ser igual a senha cadastrada', function(){
        $response = $this->postJson('/api/register', [
            'name' => 'Jeferson',
            'last_name' => 'Oliveira',
            'email' => 'testing@example.com',
            'password' => 'password',
            'password_confirmation' => 'password_teste',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['password_confirmation']);
    });
});

describe('recuperação de senha', function(){
    it('usuário não pode enviar um e-mail de solicitação de troca de senha para um e-mail que não existe na base de dados', function(){
        $response = $this->postJson('/api/recoveryPassword', [
            'email' => 'example@testing.com'
        ]);

        $response
        ->assertStatus(422)
        ->assertJsonStructure([
            "message"
        ]);
    });

    it('usuário deve informar um e-mail válido para recuperação de senha', function(){
        $response = $this->postJson('/api/recoveryPassword', [
            'email' => 'apsdlasopdkaospdkaspodksd'
        ]);

        $response
        ->assertStatus(422)
        ->assertJson([
            "message" => "O campo deve ser um e-mail válido"
        ]);
    });

    it('usuário é obrigado a informar o e-mail para recuperar a senha', function(){
        $response = $this->postJson('/api/recoveryPassword', []);

        $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
    });
});

