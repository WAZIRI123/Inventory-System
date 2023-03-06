import { createStore } from "vuex";
import * as actions from './actions'
import * as mutations from './mutations'
import state from './states'
const store = createStore({
    state,
    getters: {},
    actions,
    mutations,
    modules: {},
});

export default store;