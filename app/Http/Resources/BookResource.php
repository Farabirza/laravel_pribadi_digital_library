<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'publication_year' => $this->publication_year,
            'isbn' => $this->isbn,
            'summary' => $this->summary,
            'description' => $this->description,
            'image' => $this->image,
            'url' => $this->url,
            'keywords' => $this->keywords,
            'source' => $this->source,
            'access' => $this->access,
        ];
    }
}
