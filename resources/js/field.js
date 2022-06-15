import DetailField from './components/DetailField';
import FormField from './components/FormField';
import IndexField from './components/IndexField';

Nova.booting(Vue => {
    Vue.component('detail-permissions', DetailField);
    Vue.component('form-permissions', FormField);
    Vue.component('index-permissions', IndexField);
})
