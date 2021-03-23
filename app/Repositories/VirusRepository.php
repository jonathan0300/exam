<?php

namespace App\Repositories;

use App\Repositories\Interfaces\VirusInterface;
use App\Models\Virus;
use App\Models\Tag;

class VirusRepository implements VirusInterface
{

    private $virus, $tag;

    public function __construct(Virus $virus, Tag $tag)
    {
        $this->virus = $virus;
        $this->tag = $tag;
    }

    public function get()
    {
        return $this->virus->with('tags')->get();
    }

    public function update($id, $input)
    {
        $virus = $this->virus->with('tags')->findOrFail($id);
        $virus->name = $input['name'];
        $virus->save();

        foreach($virus->tags as $tag)
        {
            $tag->delete();
        }
        foreach($input['tmp_tags'] as $tag)
        {
            $this->tag->create(['title' => $tag, 'virus_id' => $virus->id]);
        }


    }

    public function delete($id)
    {
        $virus = $this->virus->findOrFail($id);
        $virus->delete();
    }

    public function store(array $input)
    {
        $tags = $input['tags'];
        unset($input['tags']);
        $virus = $this->virus->create($input);
        foreach ($tags as $tag) {
            $this->tag->create(['title' => $tag, 'virus_id' => $virus->id]);
        }
    }
}
