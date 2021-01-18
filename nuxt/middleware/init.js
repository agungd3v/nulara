import * as Cookies from 'js-cookie'
import {
  getCookies
} from '../helpers/Authentication'

export default function (context) {
  let lastUrl = '/'
  if (process.server) {
    lastUrl = context.req.url
    if (lastUrl != '/login' && lastUrl != '/register' && lastUrl != '/register-success') {
      context.res.setHeader('Set-Cookie', [`last_url=${lastUrl}`])
    }
  } else {
    lastUrl = context.route.path
    if (lastUrl != '/login' && lastUrl != '/register' && lastUrl != '/register-success') {
      Cookies.set('last_url', lastUrl, {
        expires: 1
      })
    }
  }
}
