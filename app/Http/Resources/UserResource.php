<?php

namespace App\Http\Resources;

use App\Services\LinkGenerator;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $links = new LinkGenerator;
        $links->post(route('api.logout'), 'usuario_deslogar');
        $links->post(route('api.changepassword'), 'usuario_trocar_senha');
        $links->post(route('api.user.update', $this->id), 'usuario_atualizar');

        return [
            'nome' => $this->name,
            'email' => $this->email,
            'usuario_criado_em' => $this->created_at,
            'token' => $this->token,
            'links' => [
                $links->toArray()
            ]
        ];
    }
}
