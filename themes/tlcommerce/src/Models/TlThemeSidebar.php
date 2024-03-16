<?php

namespace Theme\TLCommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Theme\TLCommerce\Models\TlSidebarHasWidget;

class TlThemeSidebar extends Model
{
    protected $table = "tl_theme_sidebars";
    protected $guarded = [];

    // Sidebar has many widget
    public function widgets()
    {
        return $this->hasMany(TlSidebarHasWidget::class, 'sidebar_id');
    }
}
