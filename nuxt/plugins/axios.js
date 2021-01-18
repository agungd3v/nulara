export default function ({
  $axios,
  redirect,
  store
}) {
  $axios.onRequest(async (config) => {
    let token = store.state.auth.token
    if (token !== null || token !== 'null') {
      config.headers.common['Authorization'] = token ? `Bearer ${token}` : ''
    }
    config.headers.post['Content-Type'] = 'application/json'
    return config
  })

  $axios.onError(error => {
    if (error.response.status === 500) {
      return error.response.status
    }

    if (error.response.status === 404) {
      redirect('/sorry')
    }

    if (error.response.status === 401) {
      redirect('/login')
    }
  })
}
