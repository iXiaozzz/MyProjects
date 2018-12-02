import {
  INCREMENT,
  DECREMENT
} from './types'

const state = {
  count: 20,
  token: ''
}

const getters = {
  count: (state) => {
    return state.count
  }
}

const mutations = {
  [INCREMENT](state) {
    state.count++
  },
  [DECREMENT](state) {
    state.count--
  }
}
export default {
  // namespaced: true,
  state,
  mutations,
  getters
}
