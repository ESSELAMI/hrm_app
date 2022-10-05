const admin = {
      state: {
          roles : [],
          permissions: [],
          users: [],
      },
      getters: {
            ALL_ROLES: state => {
                  return state.roles;
                  }
      },
      mutations: {
            SET_ROLES(state, roles) {
                  state.roles = roles;
          },
            FETCH_PERMISSIONS(state, permissions) {
                  state.permissions = permissions;
          },
          FETCH_ROLE_PERMISSIONS(state, role_permissions) {
                  state.role_permissions = role_permissions;
          }
      },
      actions: {
          fetch_roles({ commit }) {
                  return axios.get('/getRoles')
                        .then(response => commit('SET_ROLES', response.data.roles))
                        .catch();
          },
            fetch_role_permissions({ commit }) {
                  commit('FETCH_ROLE_PERMISSIONS')
          },
          // deleteNote({}, id) {
          //     axios.delete(`${roles}/${id}`)
          //         .then(() => this.dispatch('fetch'))
          //         .catch();
          // },
          // edit({}, note) {
          //     axios.put(`${roles}/${note.id}`, {
          //         title: note.title
          //     })
          //         .then(() => this.dispatch('fetch'));
          // },
          // toggleFavourite({}, id) {
          //     axios.put(`${roles}/${id}/toggleFavourite`, {
          //         is_favourite: true
          //     })
          //       .then(() => this.dispatch('fetch'))
          // },
          // fetchFavourite({commit}) {
          //   return axios.get(`${roles}?type=favourite`)
          //     .then(response => commit('FETCH_FAVOURITE', response.data))
          //     .catch();
          // },
          // add({}, title) {
          //     axios.post(`${roles}`, {
          //         'title': title,
          //         'is_favourite': false,
          //     });
          // }
      },
  }
export default admin;