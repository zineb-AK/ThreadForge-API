<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlueprintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray($request): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'tone' => $this->tone,
        'target_audience' => $this->target_audience,
        'max_characters' => $this->max_characters,
        'max_hashtags' => $this->max_hashtags,
        'created_at' => $this->created_at,
    ];
}
}
