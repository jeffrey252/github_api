<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GitUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'login' => $this->login,
            'company' => $this->company,
            'followers' => $this->followers,
            'public_repos' => $this->publicRepos,
            'average_followers_per_public_repo' => $this->followers / $this->publicRepos,
        ];
    }
}
