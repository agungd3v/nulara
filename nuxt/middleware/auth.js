import {
  getCookies
} from '../helpers/Authentication'
import * as Cookies from 'js-cookie'

export default function (context) {
  let token = null
  if (process.server) {
    let cookie = context.req.headers.cookie
    if (cookie) {
      token = getCookies('token', cookie)
      context.store.commit('auth/setToken', token)

      if (!token) {
        context.store.dispatch('auth/destroyed')

        return context.redirect('/login')
      }
    }
  } else {
    let token = Cookies.get('token')
    if (!token) {
      context.store.dispatch('auth/destroyed')
      return context.redirect('/login')
    }
  }
}
