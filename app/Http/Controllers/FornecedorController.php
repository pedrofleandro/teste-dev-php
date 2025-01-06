<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{

    public function index()
    {
        $fornecedores = Cache::remember('fornecedores', 3600, function(){
            return Fornecedor::all();
        });

        return response()->json($fornecedores);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['cnpj_cpf'] = preg_replace('/\D/', '', $data['cnpj_cpf']);
        $data['contato'] = preg_replace('/\D/', '', $data['contato']);

        $request->merge($data);

        $request->validate([
            'cnpj_cpf' => 'required|string|max:14|unique:fornecedores,cnpj_cpf',
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:fornecedores,email',
            'contato' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
        ]);

        $fornecedor = Fornecedor::create($request->all());

        Cache::forget('fornecedores');

        return response()->json($fornecedor, 201);
    }

    public function show(string $id)
    {
        $fornecedor = Cache::remember("fornecedor_{$id}", 3600, function () use ($id) {
            return Fornecedor::findOrFail($id);
        });
                
        return response()->json($fornecedor);
    }

    public function update(Request $request, string $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        $data = $request->all();

        $data['cnpj_cpf'] = preg_replace('/\D/', '', $data['cnpj_cpf']);
        $data['contato'] = preg_replace('/\D/', '', $data['contato']);

        $request->merge($data);

        $validatedData = $request->validate([
            'cnpj_cpf' => 'required|string|max:14',
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:fornecedores,email,' . $fornecedor->id,
            'contato' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
        ]);

        $fornecedor->update($validatedData);

        Cache::forget("fornecedor_{$id}");
        Cache::forget('fornecedores');

        return response()->json($fornecedor);
    }

    public function destroy(string $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->delete();

        Cache::forget("fornecedor_{$id}");
        Cache::forget("fornecedores");

        return response()->json(['message' => 'Fornecedor excluído com sucesso'], 200);
    }
}
