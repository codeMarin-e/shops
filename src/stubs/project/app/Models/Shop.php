<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AddVariable;
use App\Traits\MacroableModel;
use App\Traits\OpenCloseable;
use App\Traits\Orderable;

class Shop extends Model
{
    use MacroableModel;
    use Orderable;
    use AddVariable;
    use OpenCloseable;

    // @HOOK_TRAITS

    protected $fillable = ['active', 'site_id', 'ord'];
}
