export function getCookies(name, cookie) {
  let res = null
  let cok = cookie.split(';')
  cok.map(e => {
    var cek = e.split("=")
    if (cek[0].trim() === name) {
      return res = cek[1]
    }
  })
  return res
}

export function setCookies(name, value, days) {
  let e = new Date
  e.setDate(e.getDate() + (days || 365))
  document.cookie = name + "=" + value + ';expires=' + e.toUTCString() + ';path=/;domain=.' + document.domain
}

export function deleteCookie(name) {
  document.cookie = name + '=; expires=Thu, 01-Jan-2018 00:00:01 GMT;'
}
