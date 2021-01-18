import * as Cookies from 'js-cookie'
import cookie from 'cookie'


export default function ({
  req,
  redirect
}) {
  if (process.server) {
    const parsedCookies = cookie.parse(req.headers.cookie)
    if (typeof parsedCookies['token'] !== 'undefined') {
      if (parsedCookies['token']) return redirect('/')
    }
  } else {
    let token = Cookies.get('token')
    if (token) return redirect('/')
  }
}
