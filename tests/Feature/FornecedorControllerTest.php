<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use App\Models\Fornecedor;

class FornecedorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_cached_data()
    {
        Cache::shouldReceive('remember')
            ->once()
            ->with('fornecedores', 3600, \Closure::class)
            ->andReturn(Fornecedor::factory(3)->create());

        $response = $this->getJson('/api/fornecedores');

        $response->assertOk()
            ->assertJsonCount(3);
    }

    public function test_store_saves_data_and_clears_cache()
    {
        Cache::shouldReceive('forget')
            ->once()
            ->with('fornecedores');

        $data = Fornecedor::factory()->make()->toArray();

        $response = $this->postJson('/api/fornecedores', $data);

        $response->assertCreated()
            ->assertJsonFragment(['nome' => $data['nome']]);

        $this->assertDatabaseHas('fornecedores', $data);
    }

    public function test_show_returns_cached_data()
    {
        $fornecedor = Fornecedor::factory()->create();

        Cache::shouldReceive('remember')
            ->once()
            ->with("fornecedor_{$fornecedor->id}", 3600, \Closure::class)
            ->andReturn($fornecedor);

        $response = $this->getJson("/api/fornecedores/{$fornecedor->id}");

        $response->assertOk()
            ->assertJsonFragment(['nome' => $fornecedor->nome]);
    }

    public function test_update_modifies_data_and_clears_cache()
    {
        $fornecedor = Fornecedor::factory()->create();

        Cache::shouldReceive('forget')
            ->twice()
            ->withAnyArgs();

        $updatedData = [
            'cnpj_cpf' => '12345678901234',
            'nome' => 'Nome Atualizado',
            'email' => 'atualizado@example.com',
        ];

        $response = $this->putJson("/api/fornecedores/{$fornecedor->id}", $updatedData);

        $response->assertOk()
            ->assertJsonFragment(['nome' => $updatedData['nome']]);

        $this->assertDatabaseHas('fornecedores', $updatedData);
    }

    public function test_destroy_deletes_data_and_clears_cache()
    {
        $fornecedor = Fornecedor::factory()->create();

        Cache::shouldReceive('forget')
            ->twice()
            ->withAnyArgs();

        $response = $this->deleteJson("/api/fornecedores/{$fornecedor->id}");

        $response->assertOk()
            ->assertJson(['message' => 'Fornecedor excluído com sucesso']);

        $this->assertDatabaseMissing('fornecedores', ['id' => $fornecedor->id]);
    }
}
