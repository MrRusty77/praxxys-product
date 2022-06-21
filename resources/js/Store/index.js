import Vuex from "vuex";
import axios from 'axios';

export default new Vuex.Store({
    state: {
        authenticated: false,
        user_info: null,
        token: null,
        user: null,
    },
    mutations: {
        authenticateUser(state, data) {
            state.authenticated = true;
            state.token = data.token;
            state.user_info = data.user_info;
        },
        setAuthUser(state, user) {
            state.user = user;
        },
        destroyAuthentication( state ) {
            state.authenticated = false;
            state.token = null;
            state.user_info = null;
        },
    },
    actions: {
        async login( { commit }, credentials) {
            await axios.get('sanctum/csrf-cookie');
            const res = await axios.post('login', credentials);
            commit('authenticateUser', res.data)
            router.push('/');
        },
        logout( { commit } ) {
            commit('destroyAuthentication');
        }
    },
    getters: {
        isAuthenticated(state) {
            return state.authenticated;
        },
        userInfo(state) {
            return state.user_info;
        },
        userToken(state) {
            return state.token;
        },
        isLoggedIn(state) {
            return state.user !== null;
        }
    },
});