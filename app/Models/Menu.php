<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'menus';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const LINK_TYPE_RADIO = [
        '0' => 'SubMenus',
        '1' => 'Página Interna',
        '2' => 'Página Externa',
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

    public function submenuses()
    {
        return $this->belongsToMany(Submenu::class)->with(['page']);
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
