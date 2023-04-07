<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submenu extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'submenus';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const LINK_TYPE_RADIO = [
        '0' => 'Página Interna',
        '1' => 'Página Externa',
    ];

    protected $fillable = [
        'title',
        'position',
        'link_type',
        'page_id',
        'url',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
