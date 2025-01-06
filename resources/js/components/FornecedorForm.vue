<template>
  <div class="form-container">
    <h1>{{ isEdit ? 'Editar Fornecedor' : 'Adicionar Fornecedor' }}</h1>
    <form @submit.prevent="handleSubmit" class="form-card">
      <div class="form-group">
        <label for="cnpjCpf">CNPJ/CPF:</label>
        <input
          v-model="fornecedor.cnpj_cpf"
          v-mask="maskCnpjCpf"
          type="text"
          id="cnpjCpf"
          required
          placeholder="Digite o CNPJ ou CPF"
        />
      </div>
      <div class="form-group">
        <label for="nome">Nome:</label>
        <input
          v-model="fornecedor.nome"
          type="text"
          id="nome"
          required
          placeholder="Digite o nome"
        />
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input
          v-model="fornecedor.email"
          type="email"
          id="email"
          required
          placeholder="Digite o email"
        />
      </div>
      <div class="form-group">
        <label for="contato">Contato:</label>
        <input
          v-model="fornecedor.contato"
          v-mask="'(##) #####-####'" 
          type="text"
          id="contato"
          placeholder="Digite o contato (opcional)"
        />
      </div>
      <div class="form-group">
        <label for="endereco">Endereço:</label>
        <input
          v-model="fornecedor.endereco"
          type="text"
          id="endereco"
          placeholder="Digite o endereço (opcional)"
        />
      </div>
      <div class="form-actions">
        <button type="submit">
          {{ isEdit ? 'Atualizar' : 'Cadastrar' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import FornecedorService, { showToast } from '../services/FornecedorService';

export default {
  data() {
    return {
      fornecedor: {
        cnpj_cpf: '',
        nome: '',
        email: '',
        contato: '',
        endereco: '',
      },
      isEdit: false,
      maskCnpjCpf: '###.###.###-##',
    };
  },
  watch: {
    'fornecedor.cnpj_cpf'(value) {
      const length = value.replace(/\D/g, '').length;
      this.maskCnpjCpf = length > 11 ? '##.###.###/####-##' : '###.###.###-##';
    },
  },
  async created() {
    const id = this.$route.params.id;
    if (id) {
      this.isEdit = true;
      try {
        const response = await FornecedorService.get(id);
        this.fornecedor = response.data;
      } catch (error) {
        showToast('Erro ao carregar fornecedor', 'error');
      }
    }
  },
  methods: {
    sanitize(value) {
      return value.replace(/\D/g, '');
    },
    async handleSubmit() {
      try {
        const fornecedorData = {
          ...this.fornecedor,
          cnpj_cpf: this.sanitize(this.fornecedor.cnpj_cpf),
        };

        const hasData = await FornecedorService.buscaCnpjCpf(fornecedorData.cnpj_cpf);

        if (!hasData) {
          showToast('Nenhum fornecedor encontrado com este CNPJ/CPF.', 'error');
          return;
        }
      } catch (error) {
        if (error.response && error.response.status === 400) {
          showToast('CNPJ/CPF inválido. Verifique os dados e tente novamente.', 'error');
        } else if (error.response && error.response.status === 404) {
          showToast('Nenhum fornecedor encontrado com este CNPJ/CPF.', 'error');
        } else {
          showToast('Erro inesperado ao verificar CNPJ/CPF. Tente novamente mais tarde.', 'error');
        }
        return;
      }

      try {
        if (this.isEdit) {
          await FornecedorService.update(this.$route.params.id, this.fornecedor);
          showToast('Fornecedor atualizado com sucesso!', 'sucess');
        } else {
          await FornecedorService.create(this.fornecedor);
          showToast('Fornecedor cadastrado com sucesso!', 'sucess');
        }
        this.$router.push('/');
      } catch (error) {
        const errorMessage = error.response?.data?.message || 'Erro desconhecido';
        showToast(`Erro ao salvar fornecedor: ${errorMessage}`, 'error');
        console.error('Erro ao salvar fornecedor:', error);
      }
    },
  },
};
</script>
