<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Despesa extends Model
{
use HasFactory;


protected $fillable = [
'user_id',
'descricao',
'valor',
'categoria',
'data',
];


protected $casts = [
'data' => 'date',
'valor' => 'decimal:2',
];


public function user()
{
return $this->belongsTo(User::class);
}
}