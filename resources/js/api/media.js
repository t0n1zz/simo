export default {

  index: function (p) {
    return axios.get('/api/media', { params: p });
  },

  indexCu: function (p, id) {
    return axios.get('/api/media/indexCu/' + id, { params: p });
  },

  create: function () {
    return axios.get('/api/media/create');
  },

  store: function (form) {
    return axios.post('/api/media/store', form);
  },

  edit: function (id) {
    return axios.get('/api/media/edit/' + id);
  },

  update: function (id, form) {
    return axios.post('/api/media/update/' + id, form);
  },

  destroy: function (id) {
    return axios.delete('/api/media/' + id);
  },

  count: function () {
    return axios.get('/api/media/count');
  },
}
