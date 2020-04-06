<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * @property int $id
 * @property string $title
 * @property string $menu_title
 * @property string $slug
 * @property string $content
 * @property string $description
 * @property int|null $parent_id
 *
 * @property int $depth
 * @property Page $parent
 * @property Page[] $children
 */class Page extends Model
{

}
