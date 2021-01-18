import * as Cookies from 'js-cookie'

export const state = () => ({
  token: null,
  error: null,
  name: null
})

export const mutations = {

  setToken(state, value) {
    state.token = value
    if (process.browser) {
      Cookies.set('token', value, {
        expires: 1 / 24
      })
    }
  },

  setError(state, value) {
    state.error = value
  },

  setName(state, value) {
    state.name = value
  }
}

export const actions = {
  async LOGIN({
    commit
  }, params) {
    commit('setError', null)
    try {
      const response = await this.$axios.$post('/jwt/login', params)
      if (response.status) {
        let data = response.data
        commit('setToken', data.token)
        commit('setName', data.user.name)
        return
      }
      commit('setError', response.data)
      return true
    } catch (error) {
      commit('setError', 'Unauthorized')
      return false
    }
  },

  loginByRegister({
    commit
  }, params) {
    commit('setToken', params.token)
    commit('setName', params.name)
  },

  async LOGOUT({
    commit
  }) {
    Cookies.remove('token')
    commit('setToken', '')
    commit('setName', null)
    localStorage.removeItem('vuex')
  },

  destroyed({
    commit
  }) {
    commit('setToken', '')
    commit('setName', null)
    if (process.browser) {
      localStorage.removeItem('token')
    }
  }
}

export const getters = {
  token: state => state.token,
  error: state => state.error,
  name: state => state.name
}
