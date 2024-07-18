<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class PermissionsTree extends Model
{
    use NodeTrait;

    protected $fillable = ['permissions_id'];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'permissions_tree';


    public function permission()
    {
        return $this->hasOne('App\Models\Permission', 'id', 'permissions_id');
    }
}
