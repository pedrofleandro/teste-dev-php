
import FornecedorList from './components/FornecedorList.vue';
import FornecedorForm from './components/FornecedorForm.vue';

const routes = [
    { path: '/', component: FornecedorList, name: 'Home'},
    { path: '/fornecedor/:id?', component: FornecedorForm, name: 'Formulario'},
];


export default routes;
