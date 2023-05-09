<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /* O Laravel automaticamente faz uma pluralização, ou seja, 
    ele pega o nome da model e consegue identificar sozinho e 
    relacionar a uma tabela do BD, mesmo que o nome não seja o mesmo, então,
    podemos especificar o nome da tabela aqui na model */

    /* Especificando nome da tabela */
    protected $table = 'users';

    /* Atributos onde os campos são "preenchiveis". --> Campos que serão preenchidos pelo Request::all() */
    protected $fillable = ['name','email','password',];

    /* Os atributos que devem ser ocultados para serialização. */
    protected $hidden = ['password','remember_token',];

    /* Os atributos que devem ser lançados. */
    protected $casts = [
        'email_verified_at' => 'datetime',];

    /* Para tirar a opção de created_at updated_at das tabelas */
    public $timestamps = false;
}
