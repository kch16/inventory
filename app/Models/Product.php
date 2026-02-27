<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $guarded = [];

    static public function searchKeyword($search = null, $sort = 'name', $order = 'asc', $perpage = 2)
    {
        $query = self::select('id','name','sku','price','quantity','created_at');

        if(!empty($search))
        {
            $query->where(function ($q) use ($search) {
                $q->where('name','like',"%{$search}%")->orWhere('sku','like',"%{$search}%");
            });
        }

        $query->orderBy($sort,$order);

        return $query->paginate($perpage)->withQueryString();
    }

    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }
}
