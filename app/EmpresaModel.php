<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaModel extends Model
{
    protected $table='p_empresa';
    public $timestamps=false;
    protected $primaryKey='e_id';
}
