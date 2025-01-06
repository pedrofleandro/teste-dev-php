<template>
  <div>
    <h1>Fornecedor</h1>
    <button @click="goToForm()">Adicionar Fornecedor</button>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>CNPJ/CPF</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Contato</th>
            <th>Endereço</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="fornecedor in fornecedores" :key="fornecedor.id">
            <td>{{ fornecedor.cnpj_cpf }}</td>
            <td>{{ fornecedor.nome }}</td>
            <td>{{ fornecedor.email }}</td>
            <td>{{ fornecedor.contato }}</td>
            <td>{{ fornecedor.endereco }}</td>
            <td>
              <button @click="goToForm(fornecedor.id)">Editar</button>
              <button @click="deleteFornecedor(fornecedor.id)">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import FornecedorService, {showToast} from '../services/FornecedorService';

  export default {
    data() {
      return {
        fornecedores: [],
      };
    },
    methods: {
      async fetchFornecedores() {
        try {
          const response = await FornecedorService.getAll();
          this.fornecedores = response.data;
        } catch (error) {
          showToast('Erro ao carregar fornecedores.', 'error');
        }
      },
      goToForm(id = null) {
        if(id) {
          this.$router.push({name: 'Formulario', params: {id}});
        }else{
          this.$router.push({name: 'Formulario'});
        }
      },
      async deleteFornecedor(id) {
        const confirmDelete = confirm('Tem certeza que deseja excluir este fornecedor?');
        if (confirmDelete) {
          try {
            await FornecedorService.delete(id);
            this.fetchFornecedores(); 
            showToast('Fornecedor excluído com sucesso!', 'sucess');
          } catch (error) {
            showToast('Erro ao excluir fornecedor.', 'error');
          }
        }
      }
    },
    created() {
      this.fetchFornecedores();
    }
  };
</script>