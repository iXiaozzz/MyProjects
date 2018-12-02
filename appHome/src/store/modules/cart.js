const state = {
  items: []
}
const getters = {
  getItem(state) {
    return state.items;
  }
}

const actions = {
  addToCar: ({
    commit
  }, obj) => {
    commit('updateCart', obj)
  },
  deleteGoods: ({
    commit
  }, options) => {
    commit('deleteGoods', options)
  },
  jianGoodNum: ({
    commit
  }, gid) => {
    commit('jianGoodNum', gid)
  },
  addGoodNum: ({
    commit
  }, gid) => {
    commit('addGoodNum', gid)
  },
}

const mutations = {
  updateCart: (state, obj) => {
    state.items.push(obj.optGoodInfo)
    // this.$layer.msg('hello world', () => console.log('end!!!'))
    obj.layer.open({
      btn: ['确认', '去购物车'],
      content: '添加到购物车成功~',
      shade: true,
      success(layer) {
        // console.log('成功')
      },
      yes(index, $layer) {
        // console.log('确认')
        // 函数返回 false 可以阻止弹层自动关闭，需要手动关闭
        // return false;
      },
      no() {
        obj.routerSelf.replace('/cart')
        // this.$router.push('/home')
      },
      end() {
        // console.log('end')
      }
    })
  },
  deleteGoods: (state, options) => {
    for (let i = 0; state.items[i]; i++) {
      if (options.indexOf(state.items[i].goodId) > -1) {
        state.items.splice(i, 1);
        i -= 1;
      }
    }
  },
  jianGoodNum: (state, gid) => {
    for (let i = 0; state.items[i]; i++) {
      let _this = state.items[i];
      if (_this.goodId == gid) {
        _this.buyCount = _this.buyCount > 1 ? _this.buyCount - 1 : _this.buyCount;
      }
    }

  },
  addGoodNum: (state, gid) => {
    for (let i = 0; state.items[i]; i++) {
      let _this = state.items[i];
      if (_this.goodId == gid) {
        _this.buyCount += 1;
      }
    }
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
