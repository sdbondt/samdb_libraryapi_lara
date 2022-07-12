<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function store() {
        $attr = request()->validate([
            'first_name' => ['required', 'min:2', 'max:255'],
            'last_name' => ['required', 'min:2', 'max:255'],
            'email' => ['required', Rule::unique('clients', 'email')]
        ]);
        $client = Client::create($attr);
        return [
            'client' => new ClientResource($client)
        ];
    }

    public function index() {
        $clients = Client::latest()->filter(request('q'))->paginate();
        return [
            'clients' => new ClientCollection($clients)
        ];
    }

    public function show(Client $client) {
        return [
            'client' => new ClientResource($client)
        ];
    }

    public function update(Client $client) {
        $attr = request()->validate([
            'first_name' => ['sometimes', 'min:2', 'max:255'],
            'last_name' => ['sometimes', 'min:2', 'max:255'],
            'email' => ['sometimes', Rule::unique('clients', 'email')->ignore($client->id)]
        ]);

        $client->update($attr);
        return [
            'client' => new ClientResource($client)
        ];
    }

    public function destroy(Client $client) {
        $client->delete();
        return [
            'msg' => 'Client got deleted'
        ];
    }
}
