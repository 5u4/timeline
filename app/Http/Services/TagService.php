<?php

namespace App\Http\Services;

use App\Models\Tag;

/**
 * Class TagService
 * @package App\Http\Services
 */
class TagService
{
    /**
     * @param string $username
     * @param string $name
     * @param string $color
     * @return Tag
     */
    public function create(string $username, string $name, string $color): Tag
    {
        $tag = new Tag();

        $tag->username = $username;
        $tag->name = $name;
        $tag->color = $color;

        $tag->save();

        return $tag;
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $color
     * @return array
     */
    public function edit(int $id, $name, $color): array
    {
        $tag = Tag::find($id);

        $data = [];

        if (isset($name)) {
            $tag->name = $name;
            $data['name'] = $name;
        }

        if (isset($color)) {
            $tag->color = $color;
            $data['color'] = $color;
        }

        $tag->save();

        return $data;
    }
}
